<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Api;
use App\Models\GameRecord;
use App\Models\Member;
use App\Models\MemberAPi;
use App\Models\Transfer;
use App\Services\EbetService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class EbetController extends WebBaseController
{
    protected $service,$api;
    public function __construct()
    {
        $this->service = new EbetService();
        $this->api = Api::where('api_name', 'EBET')->first();
    }

    public function register($username,$password)
    {
        $res = $this->service->register($username, $password);
    }

    public function balance($username, $password)
    {
        //检查账号是否注册
        $member = $this->getMember();
        $member_api = $member->apis()->where('api_id', $this->api->id)->first();

        $return = [
            'Code' => 0,
            'Message' => 'success',
            'url' => '',
            'Data' => '',
        ];

        if (!$member_api)
        {
            $res = json_decode($this->service->register($username), TRUE);
            if ($res['Code'] != 0)
            {
                $return['Code'] = $res['status'];
                $return['Message'] = '开通账号失败！错误代码 '.$res['status'].' 请联系客服';
                return $return;
            }

            //创建api账号
            $member_api = MemberAPi::create([
                'member_id' => $member->id,
                'api_id' => $this->api->id,
                'username' => $this->api->prefix.$member->name,
                'password' => $member->original_password
            ]);
        }


        $res = json_decode($this->service->balance($username), TRUE);

        if ($res['Code'] == 0)
        {
            $m = $res['Data']['Balance'];
            $member_api->update([
                'money' => $m
            ]);
            $return['Data'] = $m;
        } else {
            $return['Code'] = $res['Code'];
            $return['Message'] = '查询余额失败！错误代码 '.$res['Code'].' 请联系客服';
        }

        return $return;
    }

    public function deposit($username, $password, $amount, $amount_type = 'money')
    {
        //检查账号是否注册
        $member = $this->getMember();
        $member_api = $member->apis()->where('api_id', $this->api->id)->first();

        $return = [
            'Code' => 0,
            'Message' => 'success',
            'url' => '',
            'Data' => '',
        ];

        if (!$member_api)
        {
            $res = json_decode($this->service->register($username), TRUE);
            if ($res['Code'] != 0)
            {
                $return['Code'] = $res['Code'];
                $return['Message'] = '开通账号失败！错误代码 '.$res['status'].' 请联系客服';
                return $return;
            }

            //创建api账号
            $member_api = MemberAPi::create([
                'member_id' => $member->id,
                'api_id' => $this->api->id,
                'username' => $this->api->prefix.$member->name,
                'password' => $member->original_password
            ]);
        }
        //判断余额
        if ($amount_type == 'money')
        {
            if ($member->money < $amount)
            {
                $return['Code'] = -1;
                $return['Message'] = '账户余额不足';
                return $return;
            }
        } else {
            if ($member->fs_money < $amount)
            {
                $return['Code'] = -1;
                $return['Message'] = '账户余额不足';
                return $return;
            }
        }

        //先扣除用户余额
        $member->decrement($amount_type , $amount);

        $result = $this->service->deposit($username,$amount);
        $res = json_decode($result, TRUE);

        if ($res['Code'] == 0)
        {
            try{
                DB::transaction(function() use($member_api, $res,$amount_type,$amount,$member,$result) {
                    //平台账户
                    $member_api->increment('money', $amount);
                    //个人账户
                    //$member->decrement($amount_type , $amount);
                    //额度转换记录
                    Transfer::create([
                        'bill_no' => getBillNo(),
                        'api_type' => $member_api->api_id,
                        'member_id' => $member->id,
                        'transfer_type' => 0,
                        'money' => $amount,
                        'transfer_in_account' => $member_api->api->api_name.'账户',
                        'transfer_out_account' => $amount_type == 'money'?'中心账户':'返水账户',
                        'result' => $result
                    ]);
                    //修改api账号余额
                    $this->api->decrement('api_money' , $amount);
                });
            }catch(\Exception $e){
                DB::rollback();
            }
        } else {
            //退回用户
            $member->increment($amount_type , $amount);
            $return['Code'] = $res['Code'];
            $return['Message'] = '错误代码 '.$res['Code'].' 请联系客服';
        }


        return $return;
    }

    public function withdrawal($username, $password, $amount, $amount_type = 'money')
    {
        //检查账号是否注册
        $member = $this->getMember();
        $member_api = $member->apis()->where('api_id', $this->api->id)->first();

        $return = [
            'Code' => 0,
            'Message' => 'success',
            'url' => '',
            'Data' => '',
        ];

        if (!$member_api)
        {
            $res = json_decode($this->service->register($username), TRUE);
            if ($res['Code'] != 0)
            {
                $return['Code'] = $res['Code'];
                $return['Message'] = '开通账号失败！错误代码 '.$res['status'].' 请联系客服';
                return $return;
            }

            //创建api账号
            $member_api = MemberAPi::create([
                'member_id' => $member->id,
                'api_id' => $this->api->id,
                'username' => $this->api->prefix.$member->name,
                'password' => $member->original_password
            ]);
        }

        if ($member_api->money < $amount)
        {
            $return['Code'] = -1;
            $return['Message'] = '余额不足';
            return $return;
        }

        $result = $this->service->withdrawal($username,$amount);
        $res = json_decode($result, TRUE);

        if ($res['Code'] == 0)
        {
            try{
                DB::transaction(function() use($member_api, $res,$amount_type,$amount,$member,$result) {
                    //平台账户
                    $member_api->decrement('money' , $amount);
                    //个人账户
                    $member->increment($amount_type , $amount);
                    //额度转换记录
                    Transfer::create([
                        'bill_no' => getBillNo(),
                        'api_type' => $member_api->api_id,
                        'member_id' => $member->id,
                        'transfer_type' => 1,
                        'money' => $amount,
                        'transfer_in_account' => $amount_type == 'money'?'中心账户':'返水账户',
                        'transfer_out_account' => $member_api->api->api_name.'账户',
                        'result' => $result
                    ]);
                    //修改api账号余额
                    $this->api->increment('api_money' , $amount);
                });
            }catch(\Exception $e){
                DB::rollback();
            }
        } else {
            $return['Code'] = $res['Code'];
            $return['Message'] = '错误代码 '.$res['Code'].' 请联系客服';
        }


        return $return;
    }

    public function login(Request $request)
    {
        $member = $this->getMember();
        $username = $member->name;
        $password = $member->original_password;
        //检查账号是否注册
        $member_api = $member->apis()->where('api_id', $this->api->id)->first();
        if (!$member_api)
        {
            $res = json_decode($this->service->register($username), TRUE);
            if ($res['Code'] != 0)
            {
                echo '开通账号失败！错误代码 '.$res['Code'].' 请联系客服';exit;
            }

            //创建api账号
            $member_api = MemberAPi::create([
                'member_id' => $member->id,
                'api_id' => $this->api->id,
                'username' => $this->api->prefix.$member->name,
                'password' => $member->original_password
            ]);
        }

        $res = json_decode($this->service->login($username, $password), TRUE);

        if ($res['Code'] == 0)
        {
            $url = $res['Data']['LoginUrl'];

            return redirect()->to($url);
        } else {
            echo '错误代码 '.$res['Code'].' 请联系客服';exit;
        }

    }

    public function getGameRecord()
    {
        set_time_limit(0);
        $end_date = date('Y-m-d H:i:s');
        $start_time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $page = 1;
        $pagesize = 100;


        $res = $this->dy('', $start_time, $end_date,$page, $pagesize);

        if ($res['Code'] == 0)
        {
            $data = $res["Data"]["Records"];

            if (count($data) > 0)
            {
                foreach($data as $value)
                {
                    if (!GameRecord::where('BillNo', $value["SceneID"])->where('api_type', $this->api->id)->first())
                    {
                        $l = strlen($this->api->prefix);
                        $PlayerName = $value["PlayerName"];
                        $name = substr($PlayerName, $l);
                        $m = Member::where('name', $name)->first();
                        switch ($value['PlatformType']) {
                            case 'AGIN':
                                $gameType = 1;
                                break;
                            case 'HUNTER':
                                $gameType = 2;
                                break;
                            case 'AGTEX':
                                $gameType = 6;
                                break;
                            case 'XIN':
                                $gameType = 3;
                                break;
                            default :
                                $gameType = 7;
                        }
                        GameRecord::create([
                            'billNo' => $value["SceneID"],
                            'playerName' => $PlayerName,
                            'agentCode' => $value["AgentCode"],
                            'gameCode' => $value["GameCode"],
                            'netAmount' => $value["TransferAmount"],
                            'betTime' => date('Y-m-d H:i:s', strtotime($value["CreateDate"]) + 12*60*60),
                            'gameType' => $gameType,
                            'betAmount' => $value["Cost"],
                            'validBetAmount' => $value["ValidBetAmount"],
                            'flag' => $value["Flag"],
                            'playType' => $value["PlayType"],
                            'currency' => $value["Currency"],
                            'tableCode' => $value["TableCode"],
                            'loginIP' => $value["LoginIP"],
                            'recalcuTime' => $value["RecalcuTime"],
                            'platformID' => $value["PlatformID"],
                            'platformType' => $value["PlatformType"],
                            'stringEx' => $value["StringEx"],
                            'remark' => $value["Remark"],
                            'round' => $value["Round"],
                            'api_type' => $this->api->id,
                            'name' => $name,
                            'member_id' => $m->id
                        ]);
                    }

                }
            }
        }

    }

    protected function dy($username, $start_time, $end_date,$page, $pagesize)
    {
        return json_decode($this->service->betrecord($username, $start_time, $end_date,$page, $pagesize), TRUE);
    }
}

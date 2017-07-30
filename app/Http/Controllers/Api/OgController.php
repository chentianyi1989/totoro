<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Api;
use App\Models\GameRecord;
use App\Models\Member;
use App\Models\MemberAPi;
use App\Models\Transfer;
use App\Services\AgService;
use App\Services\OgService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class OgController extends WebBaseController
{
    protected $service,$api;
    public function __construct()
    {
        $this->service = new OgService();
        $this->api = Api::where('api_name', 'OG')->first();
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
            $res = json_decode($this->service->register($username,$password), TRUE);
            if ($res['Code'] != 0)
            {
                $return['Code'] = $res['Code'];
                $return['Message'] = '开通账号失败！错误代码 '.$res['Code'].' 请联系客服';
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


        $res = json_decode($this->service->balance($username, $password), TRUE);

        if ($res['Code'] == 0)
        {
            $m = $res['Data']['Balance'];
            $member_api->update([
                'money' => $m
            ]);
            $return['Data'] = $m;
        } else {
            $return['Code'] = $res['Code'];
            $return['message'] = '错误代码 '.$res['Code'].' 请联系客服';
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
            $res = json_decode($this->service->register($username,$password), TRUE);
            if ($res['Code'] != 0)
            {
                $return['Code'] = $res['Code'];
                $return['Message'] = '开通账号失败！错误代码 '.$res['Code'].' 请联系客服';
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

        $result = $this->service->deposit($username, $password,$amount);
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
        }else {
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
            $res = json_decode($this->service->register($username,$password), TRUE);
            if ($res['Code'] != 0)
            {
                $return['Code'] = $res['Code'];
                $return['Message'] = '开通账号失败！错误代码 '.$res['Code'].' 请联系客服';
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

        $result = $this->service->withdrawal($username, $password,$amount);
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
        }else {
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
            $res = json_decode($this->service->register($username,$password), TRUE);
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
        $gametype = $request->get('gametype')?:1;
        $iframe = $request->get('iframe')?:0;
        $domain = $_SERVER['HTTP_HOST'];
        $res = json_decode($this->service->login($username, $password,$gametype,$iframe,$domain), TRUE);

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

        $start_at = date('Y-m-d');
        $end_at = date('Y-m-d', strtotime('+1 day'));
        //$end_at = date('Y-m-d 23:59:59');

        $res = $this->dy($start_at, $end_at);

        if ($res['Code'] == 0)
        {
            $data = $res['Data']['GameRecord'];
            if (count($data) > 0)
            {

                foreach ($data as $value)
                {
                    if (!GameRecord::where('api_type', $this->api->id)->where('rowid', $value["RowId"])->first()) {
                        $l = strlen($this->api->prefix);
                        $PlayerName = $value["AccountNumber"];
                        $name = substr($PlayerName, $l);
                        $m = Member::where('name', $name)->first();

                        GameRecord::create([
                            'rowid' => $value["RowId"],
                            'billNo' => str_random(10).'test',
                            'playerName' => $PlayerName,
                            'betAmount' => $value["TotalWager"] / 100,
                            'validBetAmount' => $value["TotalWager"] / 100,
                            'betTime' => date('Y-m-d H:i:s', strtotime($value["GameEndTime"]) + 8 * 60 * 60),
                            'gameType' =>3,
                            'netAmount' => $value["TotalPayout"] / 100 - $value["TotalWager"] / 100,
                            'platformType' => $value['GamePlatform'],
                            'api_type' => $this->api->id,
                            'name' => $name,
                            'member_id' => $m?$m->id:0,
                            'remark' => json_encode($value),

                        ]);
                    }
                }
            } else {
                echo json_encode($res);exit;
            }
        } else {
            echo json_encode($res);exit;
        }

    }

    public function getBettingRecord()
    {
        set_time_limit(0);

        $rowid = GameRecord::where('api_type', $this->api->id)->max('rowid');
        $rowid = $rowid >0 ?$rowid:'1423921395708';

        $res = json_decode($this->service->getBettingRecord( $rowid), TRUE);;

        if ($res['Code'] == 0)
        {
            $data = $res['Data']['BetRecord'];
            if (count($data) > 0)
            {
                foreach ($data as $value)
                {
                    if (!GameRecord::where('api_type', $this->api->id)->where('rowid', $value["VendorId"])->first()) {
                        $l = strlen($this->api->prefix);
                        $PlayerName = $value["UserName"];
                        $name = substr($PlayerName, $l);
                        $m = Member::where('name', $name)->first();

                        GameRecord::create([
                            'rowid' => $value["VendorId"],
                            'billNo' => $value["OrderNumber"],
                            'playerName' => $PlayerName,
                            'betAmount' => $value["BettingAmount"],
                            'validBetAmount' => $value["ValidAmount"],
                            'betTime' => date('Y-m-d H:i:s', strtotime($value["AddTime"])),
                            'gameType' =>1,//真人
                            'netAmount' => $value["WinLoseAmount"],
                            'flag' => $value['ResultType'],
                            'api_type' => $this->api->id,
                            'name' => $name,
                            'member_id' => $m?$m->id:0,
                            'remark' => json_encode($value),

                        ]);
                    }
                }
            } else {
                echo json_encode($res);exit;
            }
        } else {
            echo json_encode($res);exit;
        }
    }

    protected function dy($start_time, $end_date)
    {
        return json_decode($this->service->betrecord( $start_time, $end_date), TRUE);
    }
}

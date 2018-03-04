<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Api;
use App\Models\GameRecord;
use App\Models\Member;
use App\Models\MemberAPi;
use App\Models\Transfer;
use App\Services\BbinService;
use Illuminate\Http\Request;
use \Exception;
use DB;
class BbinController extends WebBaseController
{
    protected $service,$api;
    public function __construct()
    {
        $this->service = new BbinService();
        $this->api = Api::where('api_name', 'BBIN')->first();
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


        $res = json_decode($this->service->balance($username), TRUE);

        if ($res['Code'] == 0)
        {
            $member_api->update([
                'money' => $res['Data']
            ]);
            $return['Data'] = $res['Data'];
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

        $pageSite = $request->get('pageSite')?:'';
        $res = json_decode($this->service->login($username, $password,$pageSite), TRUE);

        if ($res['Code'] == 0)
        {
            $url = $res['Data'];

            return redirect()->to($url);
        } else {
            echo '错误代码 '.$res['Code'].' 请联系客服';exit;
        }

    }



    public function getGameRecord()
    {
        set_time_limit(0);
        $roundDate = date("Y-m-d");//$roundDate = '2016-03-13';
        //$gameKind = 3; // （0:AG  1：球类，3：视讯，5：机率，12：彩票，15：3D 厅）
        $time = time();
        $startTimeSearch = $startTime = date("H:i:s", strtotime("-18 minutes"));
        $endTimeSearch = $endTime = date('H:i:s');
        if($endTime <= '12:00:00') {
            $roundDate = date("Y-m-d", strtotime("-1 days"));//昨天
            $endTimeSearch = date('H:i:s', $time + 12 * 60 * 60);
            $startTimeSearch = date('H:i:s', $time + 12 * 60 * 60 - 18 * 60);

        } elseif('12:00:00' < $endTime && $endTime <= "12:18:00"){
            $startTimeSearch = '00:00:00';
            $endTimeSearch = date("H:i:s", $time - 12*60*60);

        } elseif ($endTime > "12:18:00") {

            $startTimeSearch = date("H:i:s", $time - 12*60*60 - 18*60);
            $endTimeSearch = date("H:i:s", $time - 12*60*60);
        }

        $page0 = 1;
        $pageLimit = 500;// 每页最大记录数 最多500

        //拉取真人
        $this->getGameRecord_live('', $roundDate,3,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

        //拉取电子
        $this->getGameRecord_game('', $roundDate,5,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

        //拉取彩票
        $this->getGameRecord_lt('', $roundDate,12,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

        //拉取体育
        $this->getGameRecord_ball('', $roundDate,1,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);
        //拉取3d
        $this->getGameRecord_3d('', $roundDate,15,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

    }

    protected function getGameRecord_live($username = '', $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit)
    {
        $res = $this->dy($username, $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

        if ($res['Code'] ==0)
        {
            $data = $res['Data'];
            if (count($data) > 0)
            {
                foreach ($data as $value)
                {
                    if (!GameRecord::where('api_type', $this->api->id)->where('billNo', $value['WagersID'])->first())
                    {
                        $l = strlen($this->api->prefix);
                        $PlayerName = $value["UserName"];
                        $name = substr($PlayerName, $l);
                        $m = Member::where('name', $name)->first();

                        GameRecord::create([
                            'billNo' => $value['WagersID'],
                            'playerName' => $value['UserName'],
                            'netAmount' => $value['Payoff'],
                            'betTime' => date("Y-m-d H:i:s",  strtotime($value['WagersDate']) + 12*60*60),
                            'betAmount' => $value['BetAmount'],
                            'validBetAmount' => $value['Commissionable'],
                            'gameType' => 1,//真人
                            'platformType' => 'BBIN',
                            'tableCode' => isset($value['GameCode'])?$value['GameCode']:'',
                            'api_type' => $this->api->id,
                            'name' => $name,
                            'member_id' => $m?$m->id:0
                        ]);
                    }
                }
            }
        }
    }
    protected function getGameRecord_game($username = '', $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit)
    {
        foreach (range(1, 3) as $v)
        {
            $res = $this->dy($username, $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit,$v);

            if ($res['Code'] ==0)
            {
                $data = $res['Data'];
                if (count($data) > 0)
                {
                    foreach ($data as $value)
                    {
                        if (!GameRecord::where('api_type', $this->api->id)->where('billNo', $value['WagersID'])->first())
                        {
                            $l = strlen($this->api->prefix);
                            $PlayerName = $value["UserName"];
                            $name = substr($PlayerName, $l);
                            $m = Member::where('name', $name)->first();

                            GameRecord::create([
                                'billNo' => $value['WagersID'],
                                'playerName' => $value['UserName'],
                                'netAmount' => $value['Payoff'],
                                'betTime' => date("Y-m-d H:i:s",  strtotime($value['WagersDate']) + 12*60*60),
                                'betAmount' => $value['BetAmount'],
                                'validBetAmount' => $value['Commissionable'],
                                'gameType' => 3,
                                'platformType' => 'BBIN',
                                'tableCode' => isset($value['GameCode'])?$value['GameCode']:'',
                                'api_type' => $this->api->id,
                                'name' => $name,
                                'member_id' => $m?$m->id:0,
                                'remark' => json_encode($value)
                            ]);
                        }
                    }
                }
            }
        }

    }
    protected function getGameRecord_ball($username = '', $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit)
    {
        $res = $this->dy($username, $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

        if ($res['Code'] ==0)
        {
            $data = $res['Data'];
            if (count($data) > 0)
            {
                foreach ($data as $value)
                {
                    if (!GameRecord::where('api_type', $this->api->id)->where('billNo', $value['WagersID'])->first())
                    {
                        $l = strlen($this->api->prefix);
                        $PlayerName = $value["UserName"];
                        $name = substr($PlayerName, $l);
                        $m = Member::where('name', $name)->first();

                        GameRecord::create([
                            'billNo' => $value['WagersID'],
                            'playerName' => $value['UserName'],
                            'netAmount' => $value['Payoff'],
                            'betTime' => date("Y-m-d H:i:s",  strtotime($value['WagersDate']) + 12*60*60),
                            'betAmount' => $value['BetAmount'],
                            'validBetAmount' => $value['Commissionable'],
                            'gameType' => 5,
                            'platformType' => 'BBIN',
                            'tableCode' => isset($value['GameCode'])?$value['GameCode']:'',
                            'api_type' => $this->api->id,
                            'name' => $name,
                            'member_id' => $m?$m->id:0,
                            'remark' => json_encode($value)
                        ]);
                    }
                }
            }
        }
    }
    protected function getGameRecord_3d($username = '', $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit)
    {
        $res = $this->dy($username, $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit);

        if ($res['Code'] ==0)
        {
            $data = $res['Data'];
            if (count($data) > 0)
            {
                foreach ($data as $value)
                {
                    if (!GameRecord::where('api_type', $this->api->id)->where('billNo', $value['WagersID'])->first())
                    {
                        $l = strlen($this->api->prefix);
                        $PlayerName = $value["UserName"];
                        $name = substr($PlayerName, $l);
                        $m = Member::where('name', $name)->first();

                        GameRecord::create([
                            'billNo' => $value['WagersID'],
                            'playerName' => $value['UserName'],
                            'netAmount' => $value['Payoff'],
                            'betTime' => date("Y-m-d H:i:s",  strtotime($value['WagersDate']) + 12*60*60),
                            'betAmount' => $value['BetAmount'],
                            'validBetAmount' => $value['Commissionable'],
                            'gameType' => 1,//真人
                            'platformType' => 'BBIN',
                            'tableCode' => isset($value['GameCode'])?$value['GameCode']:'',
                            'api_type' => $this->api->id,
                            'name' => $name,
                            'member_id' => $m?$m->id:0,
                            'remark' => json_encode($value)
                        ]);
                    }
                }
            }
        }
    }
    protected function getGameRecord_lt($username = '', $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit)
    {
        $list = [
            'LT',
            'BJ3D',
            'PL3D',
            'BBPK',
            'BB3D',
            'BBKN',
            'BBRB',
            'SH3D',
            'CQSC',
            'TJSC',
            'JXSC',
            'XJSC',
            'CQSF',
            'GXSF',
            'GDSF',
            'TJSF',
            'BJPK',
            'BJKN',
            'CAKN',
            'AUKN',
            'GDE5',
            'JXE5',
            'SDE5',
            'JLQ3',
            'JSQ3',
            'AHQ3',
            'OTHER',
        ];
        foreach ($list as $item)
        {
            $res = $this->dy($username, $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit,1,$item);

            if ($res['Code'] ==0)
            {
                $data = $res['Data'];
                if (count($data) > 0)
                {
                    foreach ($data as $value)
                    {
                        if (!GameRecord::where('api_type', $this->api->id)->where('billNo', $value['WagersID'])->first())
                        {
                            $l = strlen($this->api->prefix);
                            $PlayerName = $value["UserName"];
                            $name = substr($PlayerName, $l);
                            $m = Member::where('name', $name)->first();

                            GameRecord::create([
                                'billNo' => $value['WagersID'],
                                'playerName' => $value['UserName'],
                                'netAmount' => $value['Payoff'],
                                'betTime' => date("Y-m-d H:i:s",  strtotime($value['WagersDate']) + 12*60*60),
                                'betAmount' => $value['BetAmount'],
                                'validBetAmount' => $value['BetAmount'],
                                'gameType' => 4,
                                'platformType' => 'BBIN',
                                'tableCode' => isset($value['GameCode'])?$value['GameCode']:'',
                                'api_type' => $this->api->id,
                                'name' => $name,
                                'member_id' => $m?$m->id:0,
                                'remark' => json_encode($value)
                            ]);
                        }
                    }
                }
            }
        }


    }

    protected function dy($username ,$roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit,$subGameKind =1,$gameType = '')
    {
        return json_decode($this->service->betrecord($username, $roundDate,$gameKind,$startTimeSearch,$endTimeSearch,$page0,$pageLimit,$subGameKind,$gameType), TRUE);
    }
}

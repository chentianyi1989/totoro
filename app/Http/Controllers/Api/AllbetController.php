<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Api;
use App\Models\Member;
use App\Models\MemberAPi;
use App\Models\Transfer;
use App\Services\AgService;
use App\Services\AllbetService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class AllbetController extends WebBaseController
{
    protected $service,$api;
    public function __construct()
    {
        $this->service = new AllbetService();
        $this->api = Api::where('api_name', 'AG')->first();
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


        $res = json_decode($this->service->balance($username, $password), TRUE);

        if ($res['Code'] == 0)
        {
            $member_api->update([
                'money' => $res['Data']['Balance']
            ]);
            $return['Data'] = $res['Data']['Balance'];
        } else {
            $return['Code'] = $res['Code'];
            $return['Message'] = '余额查询失败！错误代码 '.$res['Code'].' 请联系客服';
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

        $res = json_decode($this->service->login($username, $password), TRUE);

        if ($res['Code'] == 0)
        {
            $url = $res['Data']['GameUrl'];

            return redirect()->to($url);
        } else {
            echo '进入游戏失败！错误代码 '.$res['Code'].' 请联系客服';exit;
        }

    }

    public function getGameRecord()
    {

    }
}

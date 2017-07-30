<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\WebBaseController;
use App\Services\CurlService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiClientController extends WebBaseController
{

    //查询余额
    public function check(Request $request)
    {
        $api_name = strtoupper($request->get('api_name'));
        $member = $this->getMember();
        $res = '';
        switch ($api_name){
            case 'AG':
                $mod = new AgController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'MG':
                $mod = new MgController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'BBIN':
                $mod = new BbinController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'PT':
                $mod = new PtController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'PNG':
                $mod = new PngController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'ALLBET':
                $mod = new AllbetController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'EBET':
                $mod = new EbetController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
            case 'OG':
                $mod = new OgController();
                $res =  $mod->balance($member->name, $member->original_password);
                break;
        }

        return $res;
    }

    //转入游戏
    public function deposit($api_name,$username,$password,$amount,$amount_type)
    {
        $api_name = strtoupper($api_name);
        $res = '';
        switch ($api_name){
            case 'AG':
                $mod = new AgController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'MG':
                $mod = new MgController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'BBIN':
                $mod = new BbinController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'PT':
                $mod = new PtController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'PNG':
                $mod = new PngController();
                return $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'ALLBET':
                $mod = new AllbetController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'EBET':
                $mod = new EbetController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
            case 'OG':
                $mod = new OgController();
                $res = $mod->deposit($username, $password, $amount, $amount_type);
                break;
        }

        return $res;
    }

    //转出游戏
    public function withdrawal($api_name,$username,$password,$amount,$amount_type)
    {
        $api_name = strtoupper($api_name);
        $res = '';
        switch ($api_name){
            case 'AG':
                $mod = new AgController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'MG':
                $mod = new MgController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'BBIN':
                $mod = new BbinController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'PT':
                $mod = new PtController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'PNG':
                $mod = new PngController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'ALLBET':
                $mod = new AllbetController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'EBET':
                $mod = new EbetController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
            case 'OG':
                $mod = new OgController();
                $res = $mod->withdrawal($username, $password, $amount, $amount_type);
                break;
        }

        return $res;
    }

//    public function login(Request $request)
//    {
//
//        $api_name = strtoupper($request->get('api_name'));
//        $member = $this->getMember();
//        $username = $member->name;
//        $password = $member->original_password;
//        $res= [];
//        switch ($api_name){
//            case 'AG':
//                $mod = new AgController();
//                $res =  $mod->login($username, $password, $request->get('id')?:'');
//                break;
//            case 'MG':
//                $mod = new MgController();
//                $res =  $mod->login($username, $password, $request->get('id')?:'');
//                break;
//            case 'BBIN':
//                $mod = new BbinController();
//                $res =  $mod->login($username, $password, $request->get('pageSite')?:'');
//                break;
//            case 'PT':
//                $mod = new PtController();
//                $res =  $mod->login($username,$password, $request->get('product_type'), $request->get('game_code'));
//                break;
//        }
//
//        if ($res['status'] == 0)
//            return redirect()->to($res['url']);
//        else
//            echo $res['message'];exit;
//
//    }


//    public function getRegister()
//    {
//        return view('web.api-client.ag.register');
//    }
//
//    public function postRegister(Request $request)
//    {
//        $url = config('api.check_balances_url');
//
//        $apiAccount     = $request->get('apiAccount');
//        $userName       = $request->get('userName');
//        $password       = $request->get('password');
//        $currencyCode   = $request->get('currencyCode')?:'CNY';
//        $isSpeed        = $request->get('isSpeed')?:0;
//        $isDemo         = $request->get('isDemo')?:1;
//        $salt           = config('api.salt');
//
//        $code = $salt.md5('cFMEzA2MncLPyjKwrs6QkYMd4sKCngFyKmt9'.$apiAccount.$userName.$password.$isSpeed.$isDemo.$salt);
//
//        $data = [
//            'apiAccount'    => $apiAccount,
//            'userName'      => $userName,
//            'password'      => $password,
//            'currencyCode'  => $currencyCode,
//            'isSpeed'       => $isSpeed,
//            'isDemo'        => $isDemo,
//            'code'          => $code
//        ];
//
//        $result = (new CurlService())->post($url, $data);
//        dd($result);
//    }
}

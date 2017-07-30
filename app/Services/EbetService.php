<?php
namespace App\Services;

use App\Models\Api;
use App\Services\CurlService;
class EbetService{
    public $pre;   // 玩家前缀
    public  $domain;
    public  $comId;
    public $comKey;
    public $gamePlatform;
    public $debug;
    public $salt ;
    public $betLimitCode;
    public $currencyCode;
    public $isspeed;
    public $isdemo;
    public $lang;

    public function __construct()
    {
        $mod = Api::where('api_name', 'EBET')->first();
        $this->pre = $mod->prefix;// 玩家前缀
        $this->domain = $mod->api_domain;
        $this->comId = $mod->api_id;
        $this->comKey = $mod->api_key;
        $this->gamePlatform = $mod->api_name;
        $this->debug = 0;
        $this->salt = $this->salt(5);
        $this->betLimitCode = 'A';
        $this->currencyCode = 'CNY';
        $this->isdemo = 0;
        $this->lang = 'zh-CN';
    }

    public function getToken($username, $password)
    {

    }

    public function register($username){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$this->lang.$this->salt);
        $url = "http://".$this->domain."/api/ebet/register.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'lang' => $this->lang,'isDemo'=>$this->isdemo,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 登录 http://<domain>/api/ebet/login.ashx
     */
    public function login($username,$token){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$token.$this->salt);
        $url = "http://".$this->domain."/api/ebet/Login.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'token'=>$token,'isDemo' => $this->isdemo,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
     * 存款 http://<domain>/api/ebet/deposit.ashx
     */
    public function deposit($username,$amount){
        $transSN = date("YmdHms");//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$transSN.$amount.$this->salt);
        $url = "http://".$this->domain."/api/ebet/deposit.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'transSN'=>$transSN,'amount'=>$amount,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 提款 http://<domain>/api/ebet/withdrawal.ashx
     */
    public function withdrawal($username,$amount){
        $transSN = date("YmdHms").mt_rand(100,999);//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$transSN.$amount.$this->salt);
        $url = "http://".$this->domain."/api/ebet/withdrawal.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'transSN'=>$transSN,'amount'=>$amount,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 查询余额 http://<domain>/api/ebet/balance.ashx
     */
    public function balance($username){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$this->salt);
        $url = "http://".$this->domain."/api/ebet/balance.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'isDemo'=>$this->isdemo,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
    * 游戏记录 http://<domain>/api/ebet/betrecord.ashx
    */
    public function betrecord($username,$startDate,$endDate,$PageIndex,$PageSize= 100){

        $code = $this->salt.md5($this->comKey.$this->comId.$username.$startDate.$endDate.$PageIndex.$PageSize.$this->salt);
        $url = "http://".$this->domain."/api/ebet/betrecord.ashx";
        $post_data = array('apiAccount'=>$this->comId,'username'=>$username,'startDate'=>$startDate,'endDate'=>$endDate,'PageIndex'=>$PageIndex,'PageSize'=>$PageSize,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
    * 商户余额查询
    */
    public function credit(){
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/ebet/credit.ashx";
        $post_data = array('apiAccount'=>$this->comId,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    protected function send_post($url,$post_data) {
        $result = (new CurlService())->post($url, $post_data);

        return $result;
    }

    protected function salt($length)
    {
        $key="";
        $pattern='1234567890abcdefghijklmnopqrstuvwxyz';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern{mt_rand(0,35)};
        }
        return $key;
    }
}
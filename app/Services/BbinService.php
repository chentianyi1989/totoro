<?php
namespace App\Services;

use App\Models\Api;
use App\Services\CurlService;
class BbinService{

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

    public function __construct()
    {
//        $this->pre = '7k';// 玩家前缀
//        $this->domain = "gm.dfapi.net";
//        $this->comId = 'MTmotong7k';
//        $this->comKey = 'hxx7RDp3TKHkaekjrSZYkRVGFytYeXYCJ';
//        $this->gamePlatform = 'BBIN';
//        $this->debug = 0;
//        $this->salt = $this->salt(5);
//        $this->betLimitCode = 'A';
//        $this->currencyCode = 'CNY';
//        $this->isspeed = 0;
//        $this->isdemo = 0;
        $mod = Api::where('api_name', 'BBIN')->first();
        $this->pre = $mod->prefix;// 玩家前缀
        $this->domain = $mod->api_domain;
        $this->comId = $mod->api_id;
        $this->comKey = $mod->api_key;
        $this->gamePlatform = $mod->api_name;
        $this->debug = 0;
        $this->salt = $this->salt(5);
        $this->betLimitCode = 'A';
        $this->currencyCode = 'CNY';
        $this->isspeed = 0;
        $this->isdemo = 0;
    }

    public function register($username,$password){

        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$this->salt);
        $url = "http://".$this->domain."/api/bbin/register.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 登录视讯 http://<domain>/api/ag/login.ashx
     */
    public function login($username,$password, $pageSite){
        $lang = "zh-CN";
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$lang.$this->salt);
        $url = "http://".$this->domain."/api/bbin/login.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'lang'=>$lang,'pageSite'=>$pageSite,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
     * 存款 http://<domain>/api/ag/deposit.ashx
     */
    public function deposit($username,$amount){
        //global $this->domain,$this->comId,$this->comKey,$this->currencyCode,$this->isspeed,$this->isdemo,$this->salt;
        $transSN = date("YmdHms");//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$transSN.$amount.$this->salt);
        $url = "http://".$this->domain."/api/bbin/deposit.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'transSN'=>$transSN,'amount'=>$amount,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 提款 http://<domain>/api/ag/withdrawal.ashx
     */
    public function withdrawal($username,$amount){
        //global $this->domain,$this->comId,$this->comKey,$this->currencyCode,$this->isspeed,$this->isdemo,$this->salt;
        $transSN = date("YmdHms").mt_rand(100,999);//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$transSN.$amount.$this->salt);
        $url = "http://".$this->domain."/api/bbin/withdrawal.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'transSN'=>$transSN,'amount'=>$amount,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 查询余额 http://<domain>/api/ag/balance.ashx
     */
    public function balance($username){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$this->salt);
        $url = "http://".$this->domain."/api/bbin/balance.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
    * 游戏记录 http://<domain>/api/ag/betrecord.ashx
    */
    public function betrecord($username,$roundDate,$gameKind,$startTime,$endTime,$page,$pagesize,$subGameKind =1,$gameType = '')
    {
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$roundDate.$startTime.$endTime.$gameKind.$gameType.$subGameKind.$page.$pagesize.$this->salt);
        $url = "http://".$this->domain."/api/bbin/betrecord.ashx";
        $post_data = array('apiAccount'=>$this->comId,'username'=>$username,'roundDate'=>$roundDate,'startTime'=>$startTime,'endTime'=>$endTime,'gameKind'=>$gameKind,'subGameKind' => $subGameKind, 'gameType' =>$gameType ,'pageIndex'=>$page,'pageSize'=>$pagesize,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
    * 商户余额查询
    */
    public function credit(){
        //global $this->domain,$this->comId,$this->comKey,$this->salt;
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/bbin/credit.ashx";
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
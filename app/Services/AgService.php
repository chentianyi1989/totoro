<?php
namespace App\Services;

use App\Models\Api;
use App\Services\CurlService;
class AgService{
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
        $mod = Api::where('api_name', 'AG')->first();
        $this->pre = $mod->prefix;// 玩家前缀
        $this->domain = $mod->api_domain;
        $this->comId = $mod->api_id;
        $this->comKey = $mod->api_key;
        $this->gamePlatform = $mod->api_name;
        $this->debug = 0;
        $this->salt = $this->salt(5);
        $this->betLimitCode = 'C';
        $this->currencyCode = 'CNY';
        $this->isspeed = 0;
        $this->isdemo = 0;
    }

    public function register($username,$password){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$this->isspeed.$this->isdemo.$this->salt);
        $url = "http://".$this->domain."/api/ag/register.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'betLimitCode'=>$this->betLimitCode,'currencyCode'=>$this->currencyCode,'isSpeed'=>$this->isspeed,'isDemo'=>$this->isdemo,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 登录视讯 http://<domain>/api/ag/login.ashx
     */
    public function login($username,$password,$gameType){
        $lang = "zh-CN";
        $ismobile = 0;
        $mode = 1;
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$lang.$this->isspeed.$this->isdemo.$this->salt);
        $url = "http://".$this->domain."/api/ag/login.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'lang'=>$lang,'gameType'=>$gameType,'betLimitCode'=>$this->betLimitCode,'currencyCode'=>$this->currencyCode,'isSpeed'=>$this->isspeed,'isMobile'=>$ismobile,'isDemo'=>$this->isdemo,'mode'=>$mode,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
     * 存款 http://<domain>/api/ag/deposit.ashx
     */
    public function deposit($username,$password,$amount){
        $transSN = date("YmdHms");//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$transSN.$amount.$this->isspeed.$this->isdemo.$this->salt);
        $url = "http://".$this->domain."/api/ag/deposit.ashx";
        echo $url;
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'transSN'=>$transSN,'amount'=>$amount,'currencyCode'=>$this->currencyCode,'isSpeed'=>$this->isspeed,'isDemo'=>$this->isdemo,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 提款 http://<domain>/api/ag/withdrawal.ashx
     */
    public function withdrawal($username,$password,$amount){
        $transSN = date("YmdHms").mt_rand(100,999);//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$transSN.$amount.$this->isspeed.$this->isdemo.$this->salt);
        $url = "http://".$this->domain."/api/ag/withdrawal.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'transSN'=>$transSN,'amount'=>$amount,'currencyCode'=>$this->currencyCode,'isSpeed'=>$this->isspeed,'isDemo'=>$this->isdemo,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 查询余额 http://<domain>/api/ag/balance.ashx
     */
    public function balance($username,$password){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$this->isspeed.$this->isdemo.$this->salt);
        $url = "http://".$this->domain."/api/ag/balance.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'currencyCode'=>$this->currencyCode,'isSpeed'=>$this->isspeed,'isDemo'=>$this->isdemo,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
    * 游戏记录 http://<domain>/api/ag/betrecord.ashx
    */
    public function betrecord($username,$startDate,$endDate,$page,$pagesize,$platformType = ''){

        $code = $this->salt.md5($this->comKey.$this->comId.$username.$platformType.$startDate.$endDate.$page.$pagesize.$this->salt);
        $url = "http://".$this->domain."/api/ag/betrecord.ashx";
        $post_data = array('apiAccount'=>$this->comId,'username'=>$username,'platformType'=>$platformType,'startDate'=>$startDate,'endDate'=>$endDate,'pageIndex'=>$page,'pageSize'=>$pagesize,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
    * 商户余额查询
    */
    public function credit(){
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/ag/credit.ashx";
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
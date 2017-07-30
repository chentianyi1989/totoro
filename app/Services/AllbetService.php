<?php
namespace App\Services;

use App\Models\Api;
use App\Services\CurlService;
class AllbetService{

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
        $mod = Api::where('api_name', 'ALLBET')->first();
        $this->pre = $mod->prefix;// 玩家前缀
        $this->domain = $mod->api_domain;
        $this->comId = $mod->api_id;
        $this->comKey = $mod->api_key;
        $this->gamePlatform = $mod->api_name;
        $this->salt = $this->salt(5);
    }

    /**
     * 注册
     */
    public function register($username,$password){

        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$this->salt);
        $url = "http://".$this->domain."/api/allbet/register.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 登录
     */
    public function login($username,$password){
        $lang = "zh-CN";
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$lang.$this->salt);
        $url = "http://".$this->domain."/api/allbet/login.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'lang'=>$lang,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
     * 存款
     */
    public function deposit($username,$amount){
        $transSN = date("YmdHms");//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$transSN.$amount.$this->salt);
        $url = "http://".$this->domain."/api/allbet/deposit.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'transSN'=>$transSN,'amount'=>$amount,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 提款
     */
    public function withdrawal($username,$amount){
        $transSN = date("YmdHms").mt_rand(100,999);//交易编号
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$transSN.$amount.$this->salt);
        $url = "http://".$this->domain."/api/allbet/withdrawal.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'transSN'=>$transSN,'amount'=>$amount,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 查询余额
     */
    public function balance($username,$password){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$this->salt);
        $url = "http://".$this->domain."/api/allbet/balance.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
    * 游戏记录
    */
    public function betrecord($username,$roundDate,$gameKind,$startTime,$endTime,$page,$pagesize,$subGameKind =1,$gameType = '')
    {
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$roundDate.$startTime.$endTime.$gameKind.$gameType.$subGameKind.$page.$pagesize.$this->salt);
        $url = "http://".$this->domain."/api/allbet/betrecord.ashx";
        $post_data = array('apiAccount'=>$this->comId,'username'=>$username,'roundDate'=>$roundDate,'startTime'=>$startTime,'endTime'=>$endTime,'gameKind'=>$gameKind,'subGameKind' => $subGameKind, 'gameType' =>$gameType ,'pageIndex'=>$page,'pageSize'=>$pagesize,'code'=>$code);
        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
    * 商户余额查询
    */
    public function credit(){
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/allbet/credit.ashx";
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
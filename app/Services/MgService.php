<?php
namespace App\Services;

use App\Models\Api;
use App\Services\CurlService;
class MgService
{
    public $pre ;   // 玩家前缀
    public $domain;
    public $comId;
    public $comKey ;
    public $gamePlatform ;
    public $debug;
    public $salt ;
    public $currency;
    public $bettingProfileID;


    public $guid_json ;
    public $guidCode;
    public $SessionGUID;// 获取sessionguid

    public function __construct()
    {
        $mod = Api::where('api_name', 'MG')->first();
        $this->pre = $mod->prefix;   // 玩家前缀
        $this->domain    = $mod->api_domain;
        $this->comId   = $mod->api_id;
        $this->comKey  = $mod->api_key;
        $this->gamePlatform = $mod->api_name;
        $this->debug = 0;
        $this->salt = $this->salt(5);
        $this->currency = 8;
        $this->bettingProfileID = 370;


        $this->guid_json = json_decode($this->SessionGUID(),TRUE);
        $this->guidCode = $this->guid_json["Code"];
        $this->SessionGUID = $this->guid_json["Data"];// 获取sessionguid
    }

    public function SessionGUID(){

        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/mg/sessionguid.ashx";
        $post_data = array('apiAccount'=>$this->comId,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;

    }
    /*
     * 获取币别编号 http://<domain>/api/mg/getcurrenciesfordeposit.ashx
     */
    public function getcurrenciesfordeposit(){
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/mg/getcurrenciesfordeposit.ashx";
        $post_data = array('apiAccount'=>$this->comId,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;

    }
    /*
     * 获取限红编号 http://<domain>/api/mg/getbettingprofilelist.ashx
     */
    public function getbettingprofilelist(){
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/mg/getbettingprofilelist.ashx";
        $post_data = array('apiAccount'=>$this->comId,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;

    }

    /*
     * 创建账号  http://<domain>/api/mg/register.ashx
     */

    public function register($username,$password){

        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$this->salt);
        $url = "http://".$this->domain."/api/mg/register.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'currency'=>$this->currency,'bettingProfileID'=>$this->bettingProfileID,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 登录视讯 http://<domain>/api/mg/loginlive.ashx
     */
    public function loginlive($username,$password){
        $lang = "zh-CN";
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$lang.$this->salt);
        $url = "http://".$this->domain."/api/mg/loginlive.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'lang'=>$lang,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 登录电子 http://<domain>/api/mg/loginelectronic.ashx
     */
    public function loginelectronic($username,$password,$gameName){
        $lang = "zh-CN";
        $isDemo =0;//1测试，0正常
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$gameName.$lang.$isDemo.$this->salt);
        $url = "http://".$this->domain."/api/mg/loginelectronic.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'gameName'=>$gameName,'lang'=>$lang,'isDemo'=>$isDemo,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    public function mobilelogin($username,$password,$gameType,$gameName)
    {
        $lang = "zh-CN";
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$password.$gameName.$lang.$this->salt);
        $url = "http://".$this->domain."/api/mg/mobilelogin.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'password'=>$password,'gameType'=>$gameType,'gameName'=>$gameName,'lang'=>$lang,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 存款 http://<domain>/api/mg/deposit.ashx
     */
    public function deposit($username,$amount){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$amount.$this->salt);
        $url = "http://".$this->domain."/api/mg/deposit.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'amount'=>$amount,'currency'=>$this->currency,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 提款 http://<domain>/api/mg/withdrawal.ashx
     */
    public function withdrawal($username,$amount){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$amount.$this->salt);
        $url = "http://".$this->domain."/api/mg/withdrawal.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'amount'=>$amount,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 查询余额 http://<domain>/api/mg/balance.ashx
     */
    public function balance($username){
        $code = $this->salt.md5($this->comKey.$this->comId.$username.$this->salt);
        $url = "http://".$this->domain."/api/mg/balance.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$username,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
     * 游戏记录3 http://<domain>/api/mg/playergameplayreport.ashx
     */
    public function playergameplayreport($mgusername,$starttime,$endtime,$page,$pagesize){
        $code = $this->salt.md5($this->comKey.$this->comId.$mgusername.$starttime.$endtime.$page.$pagesize.$this->salt);
        $url = "http://".$this->domain."/api/mg/playergameplayreport.ashx";
        $post_data = array('apiAccount'=>$this->comId,'userName'=>$mgusername,'dateFrom'=>$starttime,'dateTo'=>$endtime,'pageIndex'=>$page,'pageSize'=>$pagesize,'SessionGUID'=>$this->SessionGUID,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }


    /*
     * 游戏记录4 http://<domain>/api/mg/balance.ashx
     */
    public function getspinbyspindata($rowid){
        $code = $this->salt.md5($this->comKey.$this->comId.$rowid.$this->salt);
        $url = "http://".$this->domain."/api/mg/getspinbyspindata.ashx";
        $post_data = array('apiAccount'=>$this->comId,'rowID'=>$rowid,'code'=>$code);

        $receive = $this->send_post($url,$post_data);
        return $receive;
    }

    /*
* 商户余额查询
*/
    public function credit(){
        $code = $this->salt.md5($this->comKey.$this->comId.$this->salt);
        $url = "http://".$this->domain."/api/mg/credit.ashx";
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
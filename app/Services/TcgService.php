<?php
namespace App\Services;

use App\Models\Api;

class TcgService
{

    protected $url;
    protected $merchant_code;
    protected $desKey;
    protected $signKey;

    public function __construct()
    {
        $mod = Api::where('api_name', 'PT')->first();
        $this->url = $mod->api_domain;
        $this->merchant_code = $mod->api_token;
        $this->desKey = $mod->api_id;
        $this->signKey = $mod->api_key;
    }

    public function register($username, $password)
    {
        $getParams = array('username' => $username, 'currency' => 'CNY', 'method' => 'cm', 'password' => $password);
        $json_request = json_encode($getParams);
        $params =  $this->encryptText(json_encode($getParams),$this->desKey);
        //SIGN
        $sign = hash('sha256', $params . $this->signKey);
        //POST PARAMS
        $data = array('merchant_code' => $this->merchant_code, 'params' => $params , 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);

        return $result;
    }

    public function balance($username, $product_type)
    {
        $getParams = array('username' => $username, 'method' => 'gb' , 'product_type' => $product_type);
        $json_request = json_encode($getParams);
        $params =  $this->encryptText(json_encode($getParams),$this->desKey);
        //SIGN
        $sign = hash('sha256', $params . $this->signKey);

        $data = array('merchant_code' => $this->merchant_code, 'params' => $params , 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);

        return $result;
    }

    //转账 1存款2提款
    public function transfer($username, $product_type, $fund_type = 1, $amount, $reference_no)
    {
        $getParams = array('username' => $username, 'method' => 'ft' , 'product_type' => $product_type, 'fund_type' => $fund_type, 'amount' => $amount, 'reference_no' => $reference_no);
        $json_request = json_encode($getParams);
        $params =  $this->encryptText(json_encode($getParams),$this->desKey);
        //SIGN
        $sign = hash('sha256', $params . $this->signKey);

        $data = array('merchant_code' => $this->merchant_code, 'params' => $params , 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);

        return $result;
    }

    public function login($username, $product_type, $game_code,$platform = 'flash', $game_mode = 1, $view = 'Lobby', $lottery_bet_mode = '')
    {
        $language = 'zh-CN';
        $getParams = array('username' => $username, 'method' => 'lg' , 'product_type' => $product_type, 'platform' => $platform, 'game_mode' => $game_mode, 'game_code' => $game_code);
        $json_request = json_encode($getParams);
        $params =  $this->encryptText(json_encode($getParams),$this->desKey);
        //SIGN
        $sign = hash('sha256', $params . $this->signKey);

        $data = array('merchant_code' => $this->merchant_code, 'params' => $params , 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);

        return $result;
    }

    public function record($batch_name, $page)
    {
        set_time_limit(0);
        $getParams = array('batch_name' => $batch_name, 'method' => 'bd' , 'page' => $page);
        $json_request = json_encode($getParams);
        $params =  $this->encryptText(json_encode($getParams),$this->desKey);
        //SIGN
        $sign = hash('sha256', $params . $this->signKey);

        $data = array('merchant_code' => $this->merchant_code, 'params' => $params , 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);

        return $result;
    }

    public function gameList($product_type, $platform = 'all', $game_type = 'RNG', $client_type= '1')
    {
        set_time_limit(0);
        $getParams = array('product_type' => $product_type, 'method' => 'tgl' , 'platform' => $platform, 'game_type' => $game_type, 'client_type' => $client_type);
        $json_request = json_encode($getParams);
        $params =  $this->encryptText(json_encode($getParams),$this->desKey);
        //SIGN
        $sign = hash('sha256', $params . $this->signKey);

        $data = array('merchant_code' => $this->merchant_code, 'params' => $params , 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);

        return $result;
    }

    protected function encryptText($plainText, $key) {

        $padded = $this->pkcs5_pad($plainText,
            mcrypt_get_block_size("des", "ecb"));

        $encText = mcrypt_encrypt("des",$key, $padded, "ecb");
        return base64_encode($encText);
    }

    protected function decryptText($encryptText, $key) {

        $cipherText = base64_decode($encryptText);

        $res = mcrypt_decrypt("des", $key, $cipherText, "ecb");

        $resUnpadded = $this->pkcs5_unpad($res);

        return $resUnpadded;
    }


    protected function pkcs5_pad ($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    protected function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }
}
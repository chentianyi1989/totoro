<?php 

class Security {
	// +----------------------------------------------------------------------+   
	// | Willko Framework                                                     |   
	// +----------------------------------------------------------------------+   
	// | Copyright (c) 2008-2009 Willko Cheng                                 |   
	// +----------------------------------------------------------------------+   
	// | Authors: Willko Cheng <willko@foxmail.com>                           |   
	// +----------------------------------------------------------------------+   
	// $string 明文 或 密文   
	// $isEncrypt 是否加密   
	// $key 密匙   
	// 采用SHA1生成密匙簿，超过300个字符使用ZLIB压缩   
	public static function dencrypt($string, $isEncrypt = true, $key = KEY_SPACE) {   
	    if (!isset($string{0}) || !isset($key{0})) {   
	        return false;   
	    }   
	       
	    $dynKey = $isEncrypt ? hash('sha1', microtime(true)) : substr($string, 0, 40);   
	    $fixedKey = hash('sha1', $key);   
	       
	    $dynKeyPart1 = substr($dynKey, 0, 20);   
	    $dynKeyPart2 = substr($dynKey, 20);   
	    $fixedKeyPart1 = substr($fixedKey, 0, 20);   
	    $fixedKeyPart2 = substr($fixedKey, 20);   
	    $key = hash('sha1', $dynKeyPart1 . $fixedKeyPart1 . $dynKeyPart2 . $fixedKeyPart2);   
	       
	    $string = $isEncrypt ? $fixedKeyPart1 . $string . $dynKeyPart2 : (isset($string{339}) ? gzuncompress(base64_decode(substr($string, 40))) : base64_decode(substr($string, 40)));   
	       
	    $n = 0;   
	    $result = '';   
	    $len = strlen($string);   
	       
	    for ($n = 0; $n < $len; $n++) {   
	        $result .= chr(ord($string{$n}) ^ ord($key{$n % 40}));   
	    }   
	    return $isEncrypt ? $dynKey . str_replace('=', '', base64_encode($n > 299 ? gzcompress($result) : $result)) : substr($result, 20, -20);   
	}
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');    
   
class Lib_encryp {
    var $skey  = "5F33E89B2C130626F4C006712443A624"; //DiGiKliNik2020
    var $secret_iv = '2B25C6F63B2F1619B42265B8A062AD15';
    var $method = 'AES-128-CBC';
 
    public  function safe_b64encode($string) {
 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
 
    // public  function encode($value){ 
    //     if(!$value){return false;}
    //     $text = $value;
    //     $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    //     $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    //     $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
    //     return trim($this->safe_b64encode($crypttext)); 
    // }
    
    // public function decode($value){
  
    //     if(!$value){return false;}
    //     $crypttext = $this->safe_b64decode($value); 
    //     $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    //     $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    //     $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
    //     return trim($decrypttext);
    // }
 
    public $output = false;
    public  function encode($value){ 
        if(!$value){return false;}
        $key = hash('sha256', $this->skey);
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
        $output = openssl_encrypt($value, $this->method, $key, 0, $iv);
        $output = $this->safe_b64encode($output);
        return $output;
    }
    
    public function decode($value){
        if(!$value){return false;}
        $key = hash('sha256', $this->skey);
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
        $output = openssl_decrypt($this->safe_b64decode($value), $this->method, $key, 0, $iv);
        return $output;
    }
}
?>
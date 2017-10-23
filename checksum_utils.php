<?php
class ApiCrypter
{
  private $iv  = '$$appsfly.io##$$'; #Same as in JAVA
  #Same as in JAVA

  public function __construct() {
  }

  public function encrypt($str,$key) {
    $str = $this->pkcs5_pad($str);
    $iv = $this->iv;
    $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
    mcrypt_generic_init($td, $key, $iv);
    $encrypted = mcrypt_generic($td, $str);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return base64_encode($encrypted);
  }

  public function decrypt($code,$key) {
    //$code = $this->hex2bin($code);
    $iv = $this->iv;
    $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
    mcrypt_generic_init($td, $key, $iv);
    $decrypted = mdecrypt_generic($td, base64_decode($code));
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $ut =  utf8_encode(trim($decrypted));
    return $this->pkcs5_unpad($ut);
  }



  protected function pkcs5_pad ($text) {
    $blocksize = 16;
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
  }

  protected function pkcs5_unpad($text) {
    $pad = ord($text{strlen($text)-1});
    if ($pad > strlen($text)) {
      return false;
    }
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
      return false;
    }
    return substr($text, 0, -1 * $pad);
  }


  public function getSalt($length){
    return $this->random_str($length,'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
  }

  protected  function random_str($length,$keyspace) {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
      throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
      $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }
  public function getHash($salt, $data){
    return   hash('sha256', $salt.$data);
  }

  public function getCheckSum($data,$key){
    $salt = $this->getSalt(8);
    $hash = $this->getHash($salt,$data);
    $checksum = $hash.$salt;
    return $this->encrypt($checksum,$key);
  }

  public function verifyChecksum($data,$checksum,$key){
    $checksum = $this->decrypt($checksum,$key);
    $salt = substr($checksum,strlen($checksum)-8);
    $sha = substr($checksum,0,strlen($checksum)-8);
    if (strcmp($sha,$this->getHash($salt,$data)) == 0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
}
?>

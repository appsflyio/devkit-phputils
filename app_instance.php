<?php
include('checksum_utils.php');
class AFConfig{
  public $repo_url;
  public $secret_key;
  public $app_key;
  public function __construct($repo_url,$secret_key,$app_key){
    $this->repo_url=$repo_url;
    $this->secret_key=$secret_key;
    $this->app_key=$app_key;
  }
}
class AFAppInstance
{
  private $iv  = '$$appsfly.io##$$'; #Same as in JAVA
  #Same as in JAVA
  private  $config;
   private $microModuleId;

  public function __construct($config,$microModuleId) {
    $this->config=$config;
    $this->microModuleId= $microModuleId;
  }

public function exec($intent,$intent_data,$user_id){
  $data["intent"]= $intent;
  $data["data"]= json_decode($intent_data);
  $body = json_encode($data);
  $payload = $body . "|" .$this->microModuleId . "|" . $this->config->app_key ."|".$user_id;
  $checksum =(new ApiCrypter())->getCheckSum($payload,$this->config->secret_key);
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $this->config->repo_url."/executor/exec",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 50,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $body,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json",
    "X-App-Key: ".$this->config->app_key,
   "X-Checksum: ".$checksum,
   "X-Module-Handle: ".$this->microModuleId,
   "X-UUID: ".$user_id
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return  $response;
}


}

}
?>

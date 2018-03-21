<?php
include 'app_instance.php';
$repo_url="https://microapps.appsfly.io";
$secret_key="1234567890123456";
$app_key="92ae2562-aebc-468f-bc9e-aa3cdd9d39b1";
$config = new AFConfig($repo_url,$secret_key,$app_key);
$microModuleId="com.cleartrip.msactivities";
$app_instance = new AFAppInstance($config,$microModuleId);
$intent = "fetch_cities";
$intentData = json_decode('{
"trip_id": "180314157588",
"contactDetails":{
"name":"John Alex"
},
"payment_method":"online payment"
}',true);
$intent_data=json_encode($intentData);
echo $app_instance->exec($intent,$intent_data,"generic");
 ?>

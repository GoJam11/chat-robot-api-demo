<?php
$text = htmlspecialchars($_REQUEST ['text']);
$apikey = htmlspecialchars($_REQUEST ['apikey']);
$userid = htmlspecialchars($_REQUEST ['userid']);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://openapi.tuling123.com/openapi/api/v2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n        reqType: 0,\n        perception: {\n          inputText: {\n            text: \"".$text."\"\n          },\n               },\n        userInfo: {\n          apiKey: \"".$apikey."\",\n          userId: \"".$userid."\"\n        }\n      }",
  CURLOPT_HTTPHEADER => array(
    
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  
$jsoncallback = htmlspecialchars($_REQUEST ['callback']);
echo $jsoncallback . "(" . $response . ")";
}

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout/token/grant',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "app_key" : "4xnoI0zo2GiG5qK7P6vIdbMKtc",
    "app_secret" : "6xw2T1s93Ki267svSPWiNG8kN9wfIGQOmTjIc5rDwnZ11XnrexUv"
}',
  CURLOPT_HTTPHEADER => array(
    'username: 01953699533',
    'password: 6|CXs3VbH+Q',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$respdee = json_decode($response);

$idtoken = $respdee->id_token;
echo $idtoken;
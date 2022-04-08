<?php
// POST
// 6.스키마 유효성 체크 : 스키마 유효성을 체크합니다.

// Setting URL
$url = "https://aitems.apigw.ntruss.com/api/v1/schemas/validation-check";
$uri = "/api/v1/schemas/validation-check";

// Setting Request Parameters
$access_key = '3C92F2C564C1A2F36B1D'; 
$secret_key = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4'; 

date_default_timezone_set('UTC');
$time = floor(microtime(true) * 1000);

$hashString = "POST {$uri}\n{$time}\n{$access_key}";
$signature  = base64_encode(hash_hmac('sha256', $hashString, $secret_key, true));

$header   = array();
$header[] = 'Content-Type: application/json';
$header[] = "x-ncp-iam-access-key: ".$access_key;
$header[] = "x-ncp-apigw-signature-v2: ".$signature;
$header[] = "x-ncp-apigw-timestamp: ".$time;

$data = array(
    'datasetType' => 'interaction', //user, item, interaction
    'name'        => '',
    'fields'      => array(
      'name'        => '',
      'type'        => '',
      'categorical' => '',
    ),
    'description' => ''
);

$raw_post = json_encode($data, JSON_UNESCAPED_UNICODE);

$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POSTFIELDS, $raw_post);   //POST data
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

$response = curl_exec($ch);
curl_close($ch);


$res = json_decode($response, true);
var_dump($res);

?>

<!-- array(9) {
  ["serviceId"]=>
  string(11) "q3k2uukkypo"
  ["name"]=>
  string(8) "Version3"
  ["description"]=>
  string(0) ""
  ["status"]=>
  string(15) "datasetRequired"
  ["datasets"]=>
  array(0) {
  }
  ["hpConfig"]=>
  array(1) {
    ["is_enabled"]=>
    bool(false)
  }
  ["infers"]=>
  array(0) {
  }
  ["createdDate"]=>
  string(23) "2022-04-06T10:13:14.508"
  ["updatedDate"]=>
  string(23) "2022-04-06T10:13:14.508"
} -->

 <!-- 이름 중복의 경우
 array(7) {
  ["timestamp"]=>
  string(23) "2022-04-06T10:13:57.940"
  ["path"]=>
  string(13) "/api/services"
  ["status"]=>
  int(400)
  ["error"]=>
  string(14) "DUPLICATE_NAME"
  ["requestId"]=>
  string(8) "3fd67b58"
  ["errorCode"]=>
  string(11) "BAD_REQUEST"
  ["message"]=>
  string(31) "[Version3] is a duplicate name."
} -->

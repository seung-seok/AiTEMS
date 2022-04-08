<?php
// GET
// 7.기본 스키마 정보 조회 : 기본 스키마 정보(예제를)를 조회합니다.

// Setting URL
$datasetType = ''; // user, item, interaction
$url         = "https://aitems.apigw.ntruss.com/api/v1/schemas/default?datasetType={$datasetType}";
$uri         = "/api/v1/schemas/default?datasetType={$datasetType}";

// Setting Request Parameters
$access_key = '3C92F2C564C1A2F36B1D'; 
$secret_key = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4'; 

// date_default_timezone_set('UTC');
$time = floor(microtime(true) * 1000);

$hashString = "GET {$uri}\n{$time}\n{$access_key}";
$signature  = base64_encode(hash_hmac('sha256', $hashString, $secret_key, true));

$header   = array();
$header[] = 'Content-Type: application/json';
$header[] = "x-ncp-iam-access-key: ".$access_key;
$header[] = "x-ncp-apigw-signature-v2: ".$signature;
$header[] = "x-ncp-apigw-timestamp: ".$time;

$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$response = curl_exec($ch);
curl_close($ch);

$res = json_decode($response, true);
var_dump($res);
?>
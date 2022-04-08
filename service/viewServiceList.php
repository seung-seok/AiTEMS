<?php
// GET
// 3.서비스 목록 조회 : 전체 서비스 목록을 조회합니다.

// Setting URL
$url = "https://aitems.apigw.ntruss.com/api/v1/services";
$uri = "/api/v1/services";

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

 <!-- array(1) { 
  ["services"]=>
  array(2) {
    [0]=>
    array(7) {
      ["serviceId"]=>
      string(11) "kzblozze40q"
      ["name"]=>
      string(8) "Version2"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-04T16:04:43.696"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:50:30.042"
      ["actionName"]=>
      string(21) "View/getServiceDetail"
      ["permission"]=>
      string(5) "Allow"
    }
    [1]=>
    array(7) {
      ["serviceId"]=>
      string(11) "pe4dhb9xq89"
      ["name"]=>
      string(4) "USER"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-04T11:49:43.821"
      ["updatedDate"]=>
      string(23) "2022-04-04T17:14:53.874"
      ["actionName"]=>
      string(21) "View/getServiceDetail"
      ["permission"]=>
      string(5) "Allow"
    }
  }
} -->
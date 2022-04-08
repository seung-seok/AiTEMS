<?php
// POST
// 2.서비스 데이터셋 수정 : 서비스 데이터셋을 설정합니다.

// Setting URL
$serviceId = 'q3k2uukkypo';
$url       = "https://aitems.apigw.ntruss.com/api/v1/services/{$serviceId}/datasets";
$uri       = "/api/v1/services/{$serviceId}/datasets";

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
    'datasetIds' => array(
        'z3n2063uu8r', // item
        'f6xit5q19yx', // user
        'ngmd34behn6', // interactive
    )
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
  string(9) "learnable"
  ["datasets"]=>
  array(3) {
    [0]=>
    array(7) {
      ["datasetId"]=>
      string(11) "z3n2063uu8r"
      ["type"]=>
      string(4) "item"
      ["name"]=>
      string(13) "testData-item"
      ["schemaName"]=>
      string(7) "ITEM_ID"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-06T10:52:54.275"
      ["updatedDate"]=>
      string(23) "2022-04-06T11:01:06.350"
    }
    [1]=>
    array(7) {
      ["datasetId"]=>
      string(11) "f6xit5q19yx"
      ["type"]=>
      string(4) "user"
      ["name"]=>
      string(13) "testData-user"
      ["schemaName"]=>
      string(7) "USER_ID"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-06T11:00:55.934"
      ["updatedDate"]=>
      string(23) "2022-04-06T11:01:06.367"
    }
    [2]=>
    array(7) {
      ["datasetId"]=>
      string(11) "ngmd34behn6"
      ["type"]=>
      string(11) "interaction"
      ["name"]=>
      string(20) "testData-interactive"
      ["schemaName"]=>
      string(9) "TIMESTAMP"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-06T11:01:19.135"
      ["updatedDate"]=>
      string(23) "2022-04-06T11:02:04.594"
    }
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
  string(23) "2022-04-06T11:02:38.227"
} -->
<?php
// GET
// 3.데이터셋 조회 : 데이터셋을 조회합니다.

// Setting URL
$datasetId = '7we6rryi6ux';
$url = "https://aitems.apigw.ntruss.com/api/v1/services/{$datasetId}";
$uri = "/api/v1/services/{$datasetId}";

// Setting Request Parameters
$access_key = '3C92F2C564C1A2F36B1D'; 
$secret_key = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4'; 

date_default_timezone_set('UTC');
$time = floor(microtime(true) * 1000);

$hashString = "GET {$uri}\n{$time}\n{$access_key}";
$signature = base64_encode(hash_hmac('sha256', $hashString, $secret_key, true));

$header = array();
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
<!-- array(9) {
  ["serviceId"]=>
  string(11) "kzblozze40q"
  ["name"]=>
  string(8) "Version2"
  ["description"]=>
  string(0) ""
  ["status"]=>
  string(9) "learnable"
  ["datasets"]=>
  array(3) {
    [0]=>
    array(7) {
      ["datasetId"]=>
      string(11) "mm0hqcnof7j"
      ["type"]=>
      string(4) "user"
      ["name"]=>
      string(7) "user-v2"
      ["schemaName"]=>
      string(7) "USER_ID"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-04T16:03:47.087"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:04:04.645"
    }
    [1]=>
    array(7) {
      ["datasetId"]=>
      string(11) "a76mttgujjg"
      ["type"]=>
      string(11) "interaction"
      ["name"]=>
      string(13) "ineraction-v2"
      ["schemaName"]=>
      string(9) "TIMESTAMP"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-04T16:04:28.383"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:05:06.320"
    }
    [2]=>
    array(7) {
      ["datasetId"]=>
      string(11) "vbxdwqzr7pf"
      ["type"]=>
      string(4) "item"
      ["name"]=>
      string(7) "item-v2"
      ["schemaName"]=>
      string(7) "ITEM_ID"
      ["status"]=>
      string(9) "learnable"
      ["createdDate"]=>
      string(23) "2022-04-04T16:04:09.479"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:05:06.333"
    }
  }
  ["hpConfig"]=>
  array(2) {
    ["is_enabled"]=>
    bool(false)
    ["group_column"]=>
    array(1) {
      [0]=>
      string(9) "TIMESTAMP"
    }
  }
  ["infers"]=>
  array(3) {
    [0]=>
    array(6) {
      ["dataType"]=>
      string(11) "relatedItem"
      ["trainVersion"]=>
      string(11) "quyjux9urbk"
      ["status"]=>
      string(6) "enable"
      ["rowCount"]=>
      int(4)
      ["createdDate"]=>
      string(23) "2022-04-04T16:50:27.765"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:50:30.007"
    }
    [1]=>
    array(6) {
      ["dataType"]=>
      string(3) "pop"
      ["trainVersion"]=>
      string(11) "2eewxr7nx8l"
      ["status"]=>
      string(6) "enable"
      ["rowCount"]=>
      int(11)
      ["createdDate"]=>
      string(23) "2022-04-04T16:32:07.336"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:32:09.607"
    }
    [2]=>
    array(6) {
      ["dataType"]=>
      string(17) "personalRecommend"
      ["trainVersion"]=>
      string(11) "abt549g08zk"
      ["status"]=>
      string(6) "enable"
      ["rowCount"]=>
      int(7)
      ["createdDate"]=>
      string(23) "2022-04-04T16:19:34.699"
      ["updatedDate"]=>
      string(23) "2022-04-04T16:19:36.915"
    }
  }
  ["createdDate"]=>
  string(23) "2022-04-04T16:04:43.696"
  ["updatedDate"]=>
  string(23) "2022-04-04T16:50:30.042"
} -->
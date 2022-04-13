<?php
// GET
// 8.학습 목록 조회 : 전체 학습 요청 목록을 조회합니다.

// Setting URL
$serviceId = '4neju9vtfk6'; // Version2
$isRecent  = false;
$url       = "https://aitems.apigw.ntruss.com/api/v1/services/{$serviceId}/trains?isRecent={$isRecent}";
$uri       = "/api/v1/services/{$serviceId}/trains?isRecent={$isRecent}";

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
  ["trains"]=>
  array(3) {
    [0]=>
    array(8) {
      ["serviceId"]=>
      string(11) "kzblozze40q"
      ["type"]=>
      string(11) "relatedItem"
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
      ["version"]=>
      string(11) "quyjux9urbk"
      ["description"]=>
      string(0) ""
      ["status"]=>
      string(9) "completed"
      ["createdDate"]=>
      string(23) "2022-04-04T16:39:01.378"
      ["inference"]=>
      bool(true)
    }
    [1]=>
    array(8) {
      ["serviceId"]=>
      string(11) "kzblozze40q"
      ["type"]=>
      string(3) "pop"
      ["hpConfig"]=>
      array(2) {
        ["is_enabled"]=>
        bool(true)
        ["group_column"]=>
        array(1) {
          [0]=>
          string(9) "TIMESTAMP"
        }
      }
      ["version"]=>
      string(11) "2eewxr7nx8l"
      ["description"]=>
      string(0) ""
      ["status"]=>
      string(9) "completed"
      ["createdDate"]=>
      string(23) "2022-04-04T16:26:33.734"
      ["inference"]=>
      bool(true)
    }
    [2]=>
    array(8) {
      ["serviceId"]=>
      string(11) "kzblozze40q"
      ["type"]=>
      string(17) "personalRecommend"
      ["hpConfig"]=>
      array(1) {
        ["is_enabled"]=>
        bool(false)
      }
      ["version"]=>
      string(11) "abt549g08zk"
      ["description"]=>
      string(0) ""
      ["status"]=>
      string(9) "completed"
      ["createdDate"]=>
      string(23) "2022-04-04T16:07:16.493"
      ["inference"]=>
      bool(true)
    }
  }
} -->
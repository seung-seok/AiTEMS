<?php

/* API 호출 테스트
aitems 관련 api 테스트
https://api.ncloud-docs.com/docs/ai-application-service-aitems
https://api.ncloud-docs.com/docs/common-ncpapi
*/

// Setting URL
/* API 호출 테스트
aitems 관련 api 테스트
https://api.ncloud-docs.com/docs/ai-application-service-aitems
https://api.ncloud-docs.com/docs/common-ncpapi
*/

// Setting URL
// 기본 데이터 설정
date_default_timezone_set('UTC');
$unixtimestamp = round(microtime(true) * 1000);
$ncp_accesskey = "438102E301C3DB4EBD86";
$ncp_secretkey = "67B418A784EBD528B881FFA5960148FD370DA7F5";
$api_server = "https://aitems.apigw.ntruss.com";
// API URL 예시 : 상품별 가격 리스트 호출 api
$api_url = $api_url = "/api/v1/services/0t5bahznplh";//"/api/v1/schemas/serviceId";
//$api_url = $api_url."?regionCode=KR&productItemKindCode=VSVR";
$apicall_method = "DELETE";
$space = " ";
$new_line = "\n";
$is_post = false;

$postfields = array(
    // 'name'        => 'test1',
    // 'description' => ''
    'schemaName'  => 'testschme',
);

$postfields = json_encode($postfields);

// hmac으로 암호화할 문자열 설정
$message =
$apicall_method
.$space
.$api_url
.$new_line
.$unixtimestamp
.$new_line
.$ncp_accesskey;
// hmac_sha256 암호화
$msg_signature = hash_hmac("sha256", $message, $ncp_secretkey, true);
$msg_signature = base64_encode($msg_signature);
// http 호출 헤더값 설정
$http_header = array();
$http_header[] = "Content-Type:application/json";
$http_header[] = "x-ncp-apigw-timestamp:".$unixtimestamp."";
$http_header[] = "x-ncp-iam-access-key:".$ncp_accesskey."";
$http_header[] = "x-ncp-apigw-signature-v2:".$msg_signature."";
// api 호출
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_server.$api_url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 원격서버가 유효한지
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
// curl_setopt($ch, CURLOPT_POST, $is_post);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); 
$response = curl_exec($ch);
curl_close($ch);
echo $response;
exit;
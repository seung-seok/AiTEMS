<?
/*-----------------------------------------------------------------

Title	: 네이버클라우드 Aitems를 이용한 상품추천 API 호출 클래스
Author	: Han CheongHwa
Date	: 2021-04-26
Path	: /www/model/main/aitems/model_itemRecommend.php
Comment	:
    aitems 를 이용하여 인증부터, 데이터셋 생성부터 학습하기 등등 을 API로 만들었습니다.

-----------------------------------------------------------------*/

/*-----------------------------------------------------------------
Include
-----------------------------------------------------------------*/
include_once '/home/naggama/www/model/model_proto.php'; // 최상위 모델 클래스


/*-----------------------------------------------------------------
Class
-----------------------------------------------------------------*/

// 서버 git 옮기면 밑의 구조 바꿔야 할듯? 인코딩도
// 인터페이스로 고쳐보기
class model_itemRecommend extends model_proto
{
    //property
    protected $unixtimestamp;
    protected $api_url;
    protected $apicall_method;
    protected $post_Body;
    protected $signature;
    protected $api_host = 'https://aitems.apigw.ntruss.com';
    protected $ncp_accesskey = "438102E301C3DB4EBD86";
    protected $ncp_secretkey = "67B418A784EBD528B881FFA5960148FD370DA7F5";
    
    public function __construct() 
    {  
         //$unixtimestamp = round(microtime(true) * 1000);
    }

    // 접근자 바꿔야 할수도 
    public function setTimestamp()
    {
        $this->unixtimestamp = round(microtime(true) * 1000);
    }

    // url (예 ; /api/v1/schemas/0t5bahznplh)
    public function setApiUrl($apiUrl)
    {
        $this->api_url = $apiUrl;
    }

    // method type : put, post, delete ....
    public function setMethod($apiMethod)
    {
        $this->apicall_method = $apiMethod;
    }

    public function setBody($postBody) // array라서 시리얼라이즈해야할듯
    {
        $this->post_Body = json_encode($postBody);
    }

    protected function getMakeSignature()
    {
        $space = " ";
        $new_line = "\n";
        $message = 
                    $this->apicall_method
                    .$space
                    .$this->api_url
                    .$new_line
                    .$this->unixtimestamp
                    .$new_line
                    .$this->ncp_accesskey;
        return base64_encode(hash_hmac("sha256", $message, $this->ncp_secretkey, true));
    }

    public function curlCommunication()
    {
        // make Signature
        $this->signature = $this->getMakeSignature();
        
        // set header
        $http_header = array();
        $http_header[] = "Content-Type:application/json";
        $http_header[] = "x-ncp-apigw-timestamp:".$this->unixtimestamp."";
        $http_header[] = "x-ncp-iam-access-key:".$this->ncp_accesskey."";
        $http_header[] = "x-ncp-apigw-signature-v2:".$this->signature."";

        // api 호출(curl통신)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_host.$this->api_url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 원격서버가 유효한지
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->apicall_method);
        // curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_Body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); 
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

        // curl 에러

        
    }

}
?>
<?

/*-----------------------------------------------------------------
Include
-----------------------------------------------------------------*/
include __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

/*-----------------------------------------------------------------
Class
-----------------------------------------------------------------*/

class model_objectStorage
{
    //property
    protected $post_Body;
    protected $upload_Path;
    protected $bucket;
    protected $key;
    protected $api_host = 'https://kr.object.ncloudstorage.com';
    protected $ncp_accesskey = '3C92F2C564C1A2F36B1D';
    protected $ncp_secretkey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';
    
    public function __construct() 
    {  
         //$unixtimestamp = round(microtime(true) * 1000);
    }

    // 접근자 바꿔야 할수도 
    public function setTimestamp()
    {
        $this->unixtimestamp = round(microtime(true) * 1000);
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
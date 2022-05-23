<?php
/*-------------------------------------------
Title	: 네이버클라우드 Object Storage API 호출 클래스
Author	: Lee SeungSeok
Date	: 2022-04-15
Path	: /home/curation/aitems/library/uploadClass.php
Comment	:
    Object Storage에 파일 업로드에 대한 기능을 작성했고, 추후에 (변경, 삭제 등)추가 할 예정입니다.
 
    $osFileUpload = new model_osFileUpload();
    $osFileUpload->setEndpoint('https://kr.object.ncloudstorage.com'); // endpoint, 추후에 추가 될 것을 고려.
    $osFileUpload->setUploader('testfile');                            // Object Storage 에 업로드 될 파일명 입력.
    $result = $osFileUpload->multipartUpload();
-------------------------------------------*/

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

class model_osFileUpload
{
    //property
    protected $bucket = 'aitems-4232530859020';
    protected $file;
    protected $file_path;
    protected $s3Client;
    protected $key;
    protected $endpoint;
    protected $ncp_accesskey = '3C92F2C564C1A2F36B1D';
    protected $ncp_secretkey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';
    
    public function __construct() 
    {  
         
    }
 
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function sets3Client()
    {
        $s3Client = new S3Client([
            'endpoint'    => $this->endpoint,
            'region'      => 'kr-standard',
            'version'     => '2006-03-01',
            'credentials' => [
                'key'    => $this->ncp_accesskey,
                'secret' => $this->ncp_secretkey
            ],
        ]);
        return $s3Client;
        // $this->s3Client = $s3Client;
    }
    
    public function setUploader($file)
    {
        $this->file = $file;
        $this->s3Client = $this->sets3Client();

        // 업로드 할 경로의 파일명
        $this->file_path = "../file/{$this->file}.csv";
        $this->uploader = new MultipartUploader($this->s3Client, $this->file_path, [
            // 업로드 할 버킷명
            'bucket' => $this->bucket,

            // 버킷에 저장될 이름 + 확장자
            'key'    => "{$this->file}.csv",
        ]);
    }

    public function multipartUpload()
    {
        try 
        {
            $result = $this->uploader->upload();
            echo "Upload complete: {$result['ObjectURL']}\n";
        } 
        catch (MultipartUploadException $e) 
        {
            echo $e->getMessage() . "\n";
        }
    }
}
?>
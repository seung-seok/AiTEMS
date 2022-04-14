<?php
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
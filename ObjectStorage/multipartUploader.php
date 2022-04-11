<?
include __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

// Setting key
$accessKey = '3C92F2C564C1A2F36B1D';
$secretKey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';

$s3Client = new S3Client([
    'endpoint'    => 'https://kr.object.ncloudstorage.com',
    'region'      => 'kr-standard',
    'version'     => '2006-03-01',
    'credentials' => [
        'key'    => $accessKey,
        'secret' => $secretKey
    ],
]);

// Use multipart upload

// 업로드할 파일 경로
$source   = 'C:\interaction.csv'; 


$uploader = new MultipartUploader($s3Client, $source, [
    // 해당 버킷
    'bucket' => 'aitems-4232530859020', 
    
    // 버킷에 저장될 이름 + 확장자
    'key'    => 'interaction.csv',          
]);

try {
    $result = $uploader->upload();
    echo "Upload complete: {$result['ObjectURL']}\n";
} catch (MultipartUploadException $e) {
    echo $e->getMessage() . "\n";
}
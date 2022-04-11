<?
include __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\ObjectUploader;

use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;

$s3Client = new S3Client([
    'credentials' => [
        'key'    => '3C92F2C564C1A2F36B1D',
        'secret' => 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4'
    ],
    // 'profile' => 'default',
    'region' => 'kr-standard',
    'version' => '2006-03-01'
]);

// $bucket = 'aitems-4232530859020';
$bucket = 'your-bucket';
$key = 'coding.jpg';
// $key = 'my-file.zip';

// Using stream instead of file path
$source = fopen('C:\coding.jpg', 'rb');

$uploader = new ObjectUploader(
    $s3Client,
    $bucket,
    $key,
    $source
);

do {
    try {
        $result = $uploader->upload();
        if ($result["@metadata"]["statusCode"] == '200') {
            print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>');
        }
        print($result);
    } catch (MultipartUploadException $e) {
        rewind($source);
        $uploader = new MultipartUploader($s3Client, $source, [
            'state' => $e->getState(),
        ]);
    }
} while (!isset($result));

fclose($source);
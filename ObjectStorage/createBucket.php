<?php
include __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;

// Setting key
$accessKey = '3C92F2C564C1A2F36B1D';
$secretKey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';

function createBucket($s3Client, $bucketName)
{
    try {
        $result = $s3Client->createBucket([
            'Bucket' => $bucketName,
        ]);
        return 'The bucket\'s location is: ' .
            $result['Location'] . '. ' .
            'The bucket\'s effective URI is: ' . 
            $result['@metadata']['effectiveUri'];
    } catch (AwsException $e) {
        return 'Error: ' . $e->getAwsErrorMessage();
    }
}

function createTheBucket()
{
    $s3Client = new S3Client([
        'credentials' => [
            'key'    => '3C92F2C564C1A2F36B1D',
            'secret' => 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4'
        ],
        'region'  => 'kr-standard',
        'endpoint' => 'https://kr.object.ncloudstorage.com/my-bucket',
        'version' => '2006-03-01'
    ]);

    echo createBucket($s3Client, 'my-bucket');
}
// $theBucket = createTheBucket();
// var_dump($theBucket);
createTheBucket();
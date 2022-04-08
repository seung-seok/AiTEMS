<?php
include __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;


// Setting key
$accessKey = '3C92F2C564C1A2F36B1D';
$secretKey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';

// s3 생성
$s3Client = new S3Client([
    'credentials' => [
    'key' => $accessKey,
    'secret' => $secretKey
    ],
    'region' => 'kr-standard',
    'endpoint' => 'https://kr.object.ncloudstorage.com',
    'version' => '2006-03-01',
]);

$buckets = $s3Client->listBuckets();
foreach ($buckets['Buckets'] as $bucket) {
    echo $bucket['Name'] . "\n";
}
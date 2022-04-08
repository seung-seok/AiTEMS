<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$url = 'kr.object.ncloudstorage.com';
$accessKey = '3C92F2C564C1A2F36B1D';
$secretKey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';

// $s3 = Aws\S3\S3Client::factory(array(
//     'key'     => '3C92F2C564C1A2F36B1D',
//     'secret'  => 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4',
//     'endpoint'=> 'https://kr.object.ncloudstorage.com',
//     'region'  => 'ap-northeast-2',
//     'version' => 'latest'
// ));

// $s3 = new S3Client([
//     'key'     => '3C92F2C564C1A2F36B1D',
//     'secret'  => 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4',
//     'endpoint'=> $url,
//     'version'=>'latest',
//     'region' =>'us-east-1'
// ]);

$s3Client = new S3Client([
    'region'      => 'us-east-1',
    'version'     => 'latest',
    'endpoint'    => $url,
    'credentials' => [
        'key'    => $accessKey,
        'secret' => $secretKey,
    ],
]);

var_dump($s3Client->listBuckets([]));

// $result = $s3->listBuckets([]);
// var_dump($result);

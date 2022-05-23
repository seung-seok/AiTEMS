<?php
include './uploadClass.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// bucket name : aitems-4232530859020
$url       = 'https://kr.object.ncloudstorage.com/';
$accessKey = '3C92F2C564C1A2F36B1D';
$secretKey = 'C4412634FFA35270969F040D4F7C1CAA7E5D08E4';

$s3Client = new S3Client([
    'region'      => 'kr-standard',
    'version'     => '2006-03-01',
    'endpoint'    => $url,
    'credentials' => [
        'key'    => $accessKey,
        'secret' => $secretKey,
    ],
]);

$bucket = 'aitems-4232530859020';
$key = 'q3k2uukkypo_pop_q6elqefuloe';
try 
{
    $objects = $s3Client->listObjects([
        'Bucket' => $bucket
    ]);
    foreach ($objects['Contents']  as $object) {
        if(strpos($object['Key'], $key))
        {
            $str = explode('/', $object['Key']);
            $dd[] = $str[2];
            // $dd[] = $object['Key'];
        }
        // echo $object['Key'] . PHP_EOL;
    }
    var_dump($dd);
} 
catch (S3Exception $e) 
{
    echo $e->getMessage() . PHP_EOL;
}
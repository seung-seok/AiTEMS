<?php
include './uploadClass.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$url = 'https://kr.object.ncloudstorage.com/';
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

// Queue 읽어서 serviceId_type_versionId 의 형식으로 key값 지정
$key = 'q3k2uukkypo_pop_q6elqefuloe'; 
// 3m92228957q_personalRecommend_c92h9lsw5z6 & q3k2uukkypo_pop_q6elqefuloe
try 
{
    // Object Lists 를 반환
    $objects = $s3Client->listObjects([
        'Bucket' => $bucket
    ]);
    foreach ($objects['Contents']  as $object) 
    {
        if(strpos($object['Key'], $key))
        {
            $str = explode('/', $object['Key']);
            $datas[] = $str[2];
        }
    }
    
    // Object List 의 데이터를 읽어옴
    $bucket = 'aitems-4232530859020/infer_result/' . $key;
    foreach($datas as $data)
    {
        $result = $s3Client->getObject([
            'Bucket' => $bucket,
            'Key' => $data,
        ]);
        // echo $result['Body'];
        // print_r($result['Body']);
        $contents = $result['Body'];
        $contents = $contents->getContents();
        $dd[] = $contents;
        
        var_dump($contents);
        exit;    
    }
    var_dump($dd);
    exit;
} 
catch (S3Exception $e) 
{
    echo $e->getMessage() . PHP_EOL;
}
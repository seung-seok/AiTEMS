<?php
include './uploadClass.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

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

// Queue 읽어서 serviceId_type_versionId 의 형식으로 key값 지정
$objectKey = '3m92228957q_personalRecommend_c92h9lsw5z6'; 
// 3m92228957q_personalRecommend_c92h9lsw5z6 & q3k2uukkypo_pop_q6elqefuloe
try 
{
    // Object Lists 를 반환
    $objects = $s3Client->listObjects([
        'Bucket' => $bucket
    ]);

    foreach ($objects['Contents'] as $object) 
    {
        if(strpos($object['Key'], $objectKey))
        {
            $str    = explode('/', $object['Key']);
            $keys[] = $str[2];
        }
    }

    // Object List 의 데이터를 읽어옴
    $bucket = 'aitems-4232530859020/infer_result/' . $objectKey;

    foreach($keys as $key)
    {
        $result = $s3Client->getObject([
            'Bucket' => $bucket,
            'Key'    => $key,
        ]);

        // GuzzleHttp\Psr7\Stream
        $data    = $result['Body'];
        $data    = $data->getContents();
        
        // json_decode 가능한 형태로 수정
        $data  = str_replace("}\n", "},", $data);
        $data  = substr($data, 0, -1);
        $data  = '[' . $data . ']';

        $data  = json_decode($data, true);

        $i = 1;
        foreach($data as $v)
        {
            $date    = array('date' => date('Y-m-d H:i:s'));
            $data    = array_merge($v, $date);
            $datas[] = $data;
            if($i == 10)
            {
                break;
            }
            $i++;
        }
    }

    // $datas = json_encode($datas);
    $datas = json_encode($datas, JSON_PRETTY_PRINT);
    var_dump($datas);
    exit;
} 
catch (S3Exception $e) 
{
    echo $e->getMessage() . PHP_EOL;
}
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
    /*-----------------------------------------------------------------
    Object Lists (FileNames) 를 반환
    -----------------------------------------------------------------*/
    $objects = $s3Client->listObjects([
        'Bucket' => $bucket
    ]);

    foreach ($objects['Contents'] as $object) 
    {
        if(strpos($object['Key'], $objectKey))
        {
            $str    = explode('/', $object['Key']);
            $fileNames[] = $str[2];
        }
    }

    /*-----------------------------------------------------------------
    Object List 의 데이터를 읽어와 date 추가 및 파싱
    -----------------------------------------------------------------*/
    $bucket = 'aitems-4232530859020/infer_result/' . $objectKey;

    foreach($fileNames as $fileName)
    {
        $result = $s3Client->getObject([
            'Bucket' => $bucket,
            'Key'    => $fileName,
        ]);

        // GuzzleHttp\Psr7\Stream
        $data    = $result['Body'];
        $data    = $data->getContents();

        $now = date("Y-m-d H:i:s");

        $i = 0;
        $data = explode("\n", $data);
        foreach($data as $array)
        {
            // $array = 하나의 json 파일 안의 데이터 1개
            $array    = json_decode($array, true);
            
            // $eduData = 데이터 1개 + date
            $date     = array('date' => $now);
            $eduData  = array_merge($array, $date);
            $eduData  = json_encode($eduData);

            // [Set] ElasticSearch Header
            $header   = array();
            $header[] = 'Content-Type: application/json';
            $header[] = 'Authorization: Basic Y3VyYXRpb246YWl0ZW1zMjAyMiEh';
            
            // [Set] index + eduData
            $body = array("name"=>"curation_personal", "value"=>"side_b", "date"=>$now, "data"=>$eduData);
            $body = json_encode($body);

            // curation_personal_side_a/user_id
            $url = 'http://211.34.235.243:9200/curation_personal_side_b/_doc/' . $array['USER_ID'];
            $ch  = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // 목적지 서버상태가 Overload 상태인지, 또는 크리티컬한 에러가 있는 상태인지에 따라 적용
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);        // 굉장히 큰파일, 또는 느린 연결 속도(네트워크속도에 좌우됨) 등에 따라 적용
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $res_raw = curl_exec($ch);
            $error   = curl_errno($ch);

            if($error)
            {
                throw new Exception('엘라스틱 서치 PUT CURL 통신에 실패하였습니다. / ' .$error);
            }

            curl_close($ch);

            $res_decode = json_decode($res_raw, true);
            var_dump($res_decode);
            // exit;
            
            usleep(500);
            $i++;
            if($i == 100)
            {
                exit;
            }
        }
        // print_r($eduData);
    }

    
    $datas = json_encode($datas, JSON_PRETTY_PRINT);
    var_dump($datas);
    exit;
} 
catch (S3Exception $e) 
{
    echo $e->getMessage() . PHP_EOL;
}
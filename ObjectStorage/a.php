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

try
{
    $Queue_memo = '{"Bulk":{"personalRecommend":0,"pop":0,"relatedItem":0}}';
    $Queue_memo = json_decode($Queue_memo, true);

    // Bulk 여부 확인 flag
    $edu = array(
        'personalRecommend' => array(
            'flag'     => true,
            'ESindex'  => 'curation_personal',
            'ESconfig' => 'USER_ID'
        ),
        // 'pop' => array(
        //     'flag'     => true,
        //     'ESindex'  => 'curation_pop',
        //     'ESconfig' => 'TIMESTAMP'
        // ),
        'relatedItem' => array(
            'flag'     => true,
            'ESindex'  => 'curation_related',
            'ESconfig' => 'ITEM_ID'
        )
    );

    // $type = ['personalRecommend','pop','relatedItem'];
    $type = ['personalRecommend','relatedItem'];

    foreach($type as $t)
    {
        if($Queue_memo['Bulk'][$t] != 0 )
        {
            $edu[$t]['flag'] = false;
        }
    }
    // var_dump($edu);exit;

    // flag Check
    // if(!$edu['personalRecommend']['flag'] && !$edu['pop']['flag'] && !$edu['relatedItem']['flag'])
    if(!$edu['personalRecommend']['flag'] && !$edu['relatedItem']['flag'])
    {
        throw new Exception("ElasticSearch Datas already Updated");
    }
    
    $objects = $s3Client->listObjects([
        'Bucket' => $bucket
    ]);

    foreach($type as $t)
    {
        if($edu[$t]['flag'])
        {
            var_dump($t);
            /*-----------------------------------------------------------------
            Object Lists (FileNames) 를 반환
            -----------------------------------------------------------------*/
            

            // type별로 objectKey 설정
            // $objectKey = $Queue_serviceId . '_' . $t . '_' . $Queue_versionId;
            // $objectKey = '4neju9vtfk6_' . $t . '_xbq3s621ky8';
            $objectKey = 'qlcg0cqbcn9_' . $t . '_b2t6k9w3aua';
            $fileNames = array();
            foreach ($objects['Contents'] as $object) 
            {
                if(strpos($object['Key'], $objectKey))
                {
                    $str         = explode('/', $object['Key']);
                    $fileNames[] = $str[2];
                }
            }
            // var_dump($fileNames);exit;
            
            // fileNames Check
            if(!isset($fileNames))
            {
                throw new Exception("Object Lists 조회 실패");
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
                // var_dump($data);exit;
                foreach($data as $array)
                {
                    // $array = 하나의 json 파일 안의 데이터 1개
                    $array    = json_decode($array, true);
                    
                    // $eduData = 데이터 1개 + date
                    $date     = array('date' => $now);
                    $eduData  = array_merge($array, $date);
                    // var_dump($eduData);exit;
                    // $eduData  = json_encode($eduData);

                    // [Set] ElasticSearch Header
                    $header   = array();
                    $header[] = 'Content-Type: application/json';
                    $header[] = 'Authorization: Basic Y3VyYXRpb246YWl0ZW1zMjAyMiEh';
                    
                    // [Set] index + eduData
                    // $body = array("name"=>$edu[$t]['ESindex'], "value"=>"side_b", "date"=>$now, "data"=>$eduData);
                    $body = json_encode($eduData);

                    // curation_personal_side_a/user_id
                    // USER_ID, ITEM_ID, 등등으로 추후에 수정해야 함. 검증 필요
                    $url = 'http://211.34.235.243:9200/' . $edu[$t]['ESindex'] . '_side_b/_doc/' . $array[$edu[$t]['ESconfig']];
                    // var_dump($url);exit;
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
                    var_dump($res_decode);var_dump($now);exit;
                    
                    usleep(500);
                    $i++;
                    if($i == 1)
                    {
                        break;
                        // continue;
                        // throw new Exception('10개');
                    }
                }
            }

            // $datas = json_encode($datas, JSON_PRETTY_PRINT);
            // var_dump($datas);
            $Queue_memo['Bulk'][$t] = time();
        }
    }

    // Queue Memo Update
    $Queue_memo = json_encode($Queue_memo);

    $sql = "
    UPDATE 
        aitems_dataQueue
    SET 
        memo      = '" . $Queue_memo . "'
    WHERE no = '" . $Queue_no . "'
    ";

    mysqli_query($ait, $sql);

}
catch(Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
    exit;
}
?>
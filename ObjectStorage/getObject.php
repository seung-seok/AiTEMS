<?php
include './uploadClass.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// bucket name : aitems-4232530859020
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

// $bucket = 'aitems-4232530859020';
// $key    = '3m92228957q_personalRecommend_c92h9lsw5z6'; 
// 이게 메인
$bucket = 'aitems-4232530859020/infer_result/3m92228957q_personalRecommend_c92h9lsw5z6';
$key    = 'part-00000-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json'; 
// $bucket = 'aitems-4232530859020/infer_result';
// $key    = '3m92228957q_personalRecommend_c92h9lsw5z6'; 

try
{
    $result = $s3Client->getObject([
        'Bucket' => $bucket,
        'Key' => $key,
    ]);
    echo $result['Body'];

} 
catch (S3Exception $e) 
{
    echo $e->getMessage() . "\n";
}

// array(20) {
//     [0]=>
//     string(57) "part-00000-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [1]=>
//     string(57) "part-00001-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [2]=>
//     string(57) "part-00002-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [3]=>
//     string(57) "part-00003-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [4]=>
//     string(57) "part-00004-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [5]=>
//     string(57) "part-00005-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [6]=>
//     string(57) "part-00006-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [7]=>
//     string(57) "part-00007-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [8]=>
//     string(57) "part-00008-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [9]=>
//     string(57) "part-00009-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [10]=>
//     string(57) "part-00010-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [11]=>
//     string(57) "part-00011-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [12]=>
//     string(57) "part-00012-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [13]=>
//     string(57) "part-00013-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [14]=>
//     string(57) "part-00014-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [15]=>
//     string(57) "part-00015-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [16]=>
//     string(57) "part-00016-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [17]=>
//     string(57) "part-00017-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [18]=>
//     string(57) "part-00018-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//     [19]=>
//     string(57) "part-00019-bdb9b71c-4d4d-483c-8813-378b45fcdb29-c000.json"
//   }
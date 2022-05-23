<?php
/*-----------------------------------------------------------------
Include
-----------------------------------------------------------------*/
// $DOCUMENT_ROOT = "/home/curation";
// include $DOCUMENT_ROOT . '/config/db.php';
$DOCUMENT_ROOT = '/c/home/AiTEMS';

$cfg['ngm']   = array(
    'MysqlHost'     => '211.34.230.226',
    'MysqlUser'     => 'dev04',
    'MysqlPass'     => 'cjdghk1174',
    'MysqlName'     => 'gng_naggama',
);

// $cfg['dev']   = array(
//     'MysqlHost'     => '172.16.6.10',
//     'MysqlUser'     => 'gng_naggama',
//     'MysqlPass'     => 'ehsRktm2021!!',
//     'MysqlName'     => 'gng_naggama',
// );

$conn = mysqli_connect(
    $cfg['ngm']['MysqlHost'], 
    $cfg['ngm']['MysqlUser'], 
    $cfg['ngm']['MysqlPass'], 
    $cfg['ngm']['MysqlName']
);

if(!$conn)
{
    echo "DB Connection Error";
    exit;
}
// 현재 연월 디렉토리에 대한 여부 확인
$now  = strtotime('NOW');
$time = date('Ym', $now);

// 업로드할 디렉토리
$upath = $DOCUMENT_ROOT . '/file/' . $time;

if(!file_exists($upath))
{
    mkdir($upath, 0777);
}

$fp = @fopen($DOCUMENT_ROOT . '/file/' . $time . '/interaction.csv', 'w');

$sql = "
SELECT 
    itemNo, buyId, date
FROM 
    ngm_order
where 
    status<>'NONE' and date <= -1638284400 and date >= -1648738799 and panchok='' 
limit 1000
";

$selectQueue = mysqli_query($conn, $sql);

if(!$selectQueue)
{
    echo "No Data";
    exit;
}

fputcsv($fp, array('USER_ID', 'ITEM_ID', 'TIMESTAMP'));

while($param = mysqli_fetch_array($selectQueue))
{
    $temp = array($data['buyId'], $data['itemNo'], $data['date']*-1);
    fputcsv($fp, $temp);
    unset($temp);
}

mysqli_close($conn);

?>
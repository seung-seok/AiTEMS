<?
include './uploadClass.php';

$osFileUpload = new model_osFileUpload();
$osFileUpload->setEndpoint('https://kr.object.ncloudstorage.com');
$osFileUpload->setUploader('testcsv');
$result = $osFileUpload->multipartUpload();
var_dump($result);
?>
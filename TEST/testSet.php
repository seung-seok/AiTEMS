<?
// aitems 클래스 테스트
$DOCUMENT_ROOT = "/home/naggama/www";
include $DOCUMENT_ROOT . '/main/common/include/inc_common.php';
include $DOCUMENT_ROOT . '/model/main/aitems/model_itemRecommend.php';
/*-----------------------------------------------------------------
db connect
-------------------------------------------------------------------*/
// DB는 아직 없음~~주문서쪽 이나 dummy값 가져와야할듯
$aitmes = new model_itemRecommend();
$aitmes->setTimestamp();
$aitmes->setApiUrl('/api/v1/services');
$aitmes->setMethod('POST');
$aitmes->setBody(array('name' => 'test'));
$result = $aitmes->curlCommunication();
var_dump($result);
?>
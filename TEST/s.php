<?
// $data = array(
//         'senderKey'           => '4a0051110e5204358fbd455fc296c4d3d54fa3e2',    // 발신키
//         'templateCode'        => $param['templateCode'],                        // 등록한 발송 템플릿 코드 (최대 20자), 흥정-배송비견적취소(구매자)에 대한 템플릿
//         'requestDate'         => $param['requestDate'],                         // 요청 일시 (yyyy-MM-dd HH:mm)(입력하지 않을 경우 즉시 발송)최대 30일 이후까지 예약 가능
//         'senderGroupingKey'   => $param['senderGroupingKey'],                   // 발신 그룹핑 키 (최대 100자)
//         'createUser'          => $param['createUser'],                          // 등록자 (콘솔에서 발송 시 사용자 UUID로 저장)
//         'recipientList'       => [                                              // 수신자 리스트 (최대 1,000명)
//             [
//                 "recipientNo"          =>$param['recipientNo'],                  // 수신번호 (최대 15자)
//                 "content"              =>$param['messageBody'],                  
//                 "buttons"              =>json_decode($param['buttons']),         
//                 "templateTitle"        =>$param['messageTitle'],                 // template 제목 (최대 50자)
                
//                 "resendParameter"       =>[                                                // 대체 발송 정보
//                     "isResend"      => $param['isResend'],                                 // 발송 실패 시, 문자 대체 발송 여부,콘솔에서 대체 발송 설정 시, 기본으로 대체 발송됩니다
//                     "resendType"    => $param['resendType'],                               // 대체 발송 타입(SMS,LMS)
//                     "resendTitle"   => mb_substr($param['resendTitle'],0,255,'euc-kr'),    // LMS 대체 발송 제목
//                     "resendContent" => mb_substr($param['resendContent'],0,255,'euc-kr'),  // 대체 발송 내용, 표준 규격 : 90바이트(한글 45자, 영문 90자)
//                     "resendSendNo"  => $param['resendSendNo']                              // 대체 발송 발신 번호
//                 ],
//                 "recipientGroupingKey"  =>$param['recipientGroupingKey']         // 수신자 그룹핑 키 (최대 100자)
//             ]
//         ],
//         "messageOption" => json_decode($param['messageOption'])                  // 메시지 옵션
//     );
    
//     $raw_post = json_encode($data, JSON_UNESCAPED_UNICODE);
//     var_dump($raw_post);
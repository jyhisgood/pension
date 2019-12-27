<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('../classes/SendSMS.php');


//설정돼있지 않다면 return
if ($board['bo_2']=="0" || $board['bo_2']=="") {
	return;
}


//*설정한 예약 대기시간 이내로 완료처리가 안될 시 예약 취소 처리

//예약대기중인 객실을 가져옴
$sql = "SELECT * FROM {$g5['write_prefix']}{$board['bo_1']} WHERE wr_6 = '예약대기'";
$result = sql_query($sql);


$keep;
$i = 0;
while ($row = sql_fetch_array($result)) {
	$keep[$i]['wr_datetime'] = $row['wr_datetime'];
	$keep[$i]['wr_id'] = $row['wr_id'];
	$i++;
}



if ($keep!="") {
	//시간 비교 후 취소처리

	$aa = array();
	for ($i=0; $i < count($keep); $i++) { 
		$write_time = strtotime($keep[$i]['wr_datetime']."+".$board['bo_2']." hours");
		// $write_time = strtotime($keep[$i]['wr_datetime']."+1 minutes");
		$current_time = strtotime("Now");

		if ($current_time > $write_time) {
			//취소완료로 수정함
			$sql = "UPDATE {$g5['write_prefix']}{$board['bo_1']} SET wr_4 = '', wr_6 = '취소완료' WHERE wr_id = '{$keep[$i]['wr_id']}'";
			sql_query($sql);

			//취소완료 메세지 발송을 위한 쿼리
			$sql = "SELECT * FROM {$g5['write_prefix']}{$board['bo_1']} WHERE wr_id = '{$keep[$i]['wr_id']}'";
			$sms_msg[] = sql_fetch($sql);
			
		}
		
	}
	$result = $sms_msg;
	$sms = new SendSMS();
	
	for ($i=0; $i < count($result); $i++) { 
	
		$sms->setSMS($result[$i]);
		$sms->send();
	
	}
	
}

?>

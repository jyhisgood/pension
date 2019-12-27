<?php 
include_once('./_common.php');
include_once('../../oon_pension/classes/SendSMS.php');

if ($_POST['status'] == "update") {

	//예약수정
	$table = "g5_write_".$_POST['bo_table'];
	

	$sql = "SELECT * FROM  $table WHERE wr_id = '{$_POST['id']}'";
	$result = sql_fetch($sql);

	$cur_status = $result['wr_6'];
	
	$sql = "update $table set wr_6 = '{$_POST['value']}' where wr_id = '{$_POST['id']}'";
	
	sql_query($sql);

	
	
	
	if ($cur_status == "취소완료") {
		if ($result['wr_9']==$result['wr_10']) {
			$date_cul = $result['wr_9'];
		}else{
			$in = strtotime($result['wr_9']);
			$out = strtotime('-1 day',strtotime($result['wr_10']));

			while ($in <= $out) {
			
				$aray[] = date("Y-m-d",$in);
				$in = strtotime("+1 day",$in);
			
			}
			$date_cul = implode(';', $aray);	
		}
		$sql = "UPDATE $table SET wr_4 = '{$date_cul}' WHERE wr_id = '{$_POST['id']}'";
		sql_query($sql);
	}
	

	
	$result['wr_6'] = $_POST['value'];

	//문자 발송
	$sms = new SendSMS();
	$sms->setSMS($result);
	$sms->send();

	echo json_encode($sql); 

}elseif($_POST['status'] == "cancel"){
	//예약수정
	$table = "g5_write_".$_POST['bo_table'];
	
	$sql = "update $table set wr_4 = '' where wr_id = '{$_POST['id']}'";
	sql_query($sql);

	$sql = "update $table set wr_6 = '취소완료' where wr_id = '{$_POST['id']}'";
	sql_query($sql);

	
	$sql = "SELECT * FROM  $table WHERE wr_id = '{$_POST['id']}'";
	$result = sql_fetch($sql);

	$sms = new SendSMS();
	$sms->setSMS($result);
	$sms->send();
}


?>
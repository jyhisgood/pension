<?
include_once('./_common.php');
include_once('../classes/SendSMS.php');
if (isset($_POST['array_id'])) {
 	$_POST['array_id'] = array_unique($_POST['array_id']);
	foreach ($_POST['array_id'] as $value) {
	 	$temp[] = $value;
	}
	$_POST['array_id'] = $temp;
}
 


if ($_POST['status'] == "update") {
	
	$use_sms = true;
	
	//예약수정
	$table = "g5_write_".$_POST['bo_1'];
	
	$array_id = $_POST['array_id'];
	for ($i=0; $i < count($array_id); $i++) { 
		if (strpos($array_id[$i], "un")!==false) {
			$val =substr($array_id[$i], 3);
			$sql = "update {$g5['meta_table']} set mta_value = '예약완료' where mta_idx = '{$val}'";
			sql_query($sql);
		}elseif (strpos($array_id[$i], "null")!==false) {
			$abc[] = explode(";", $_POST['array_date'][$i]);
		}else{
			//게시물 완료처리

			$sql = "update $table set wr_6 = '예약완료' where wr_id = '{$_POST['array_id'][$i]}'";
			sql_query($sql);
		}
	}
	if ($abc) {
		for ($i=0; $i < count($abc); $i++) { 
		
			meta_update(array("mta_db_table"=>"reserved","mta_db_id"=>$abc[$i][1] ,"mta_key"=>$abc[$i][0],"mta_value"=>"예약완료"));
		}
	}
	
	

}elseif($_POST['status'] == "reg"){

	// $use_sms = true;
	$table = "g5_write_".$_POST['bo_1'];
	$array_id = $_POST['array_id'];

	for ($i=0; $i < count($array_id); $i++) {

		$abc[] = explode(";", $_POST['array_date'][$i]);

	}

	for ($i=0; $i < count($abc); $i++) { 
		
		meta_update(array("mta_db_table"=>"reserved","mta_db_id"=>$abc[$i][1] ,"mta_key"=>$abc[$i][0],"mta_value"=>"예약대기"));
	}

}elseif ($_POST['status'] == "delete") {
	$use_sms = true;
	//예약취소
	$array_id = $_POST['array_id'];
	$table = "g5_write_".$_POST['bo_1'];

	for ($i=0; $i < count($_POST['array_id']); $i++) { 
		if (strpos($array_id[$i], "null")!==false) {
			
			
		}elseif (strpos($array_id[$i], "un")!==false) {
			$val =substr($array_id[$i], 3);
			$sql = "DELETE FROM {$g5['meta_table']} WHERE mta_idx = '{$val}'";
			sql_query($sql);
		}else{
			// $sql = "DELETE FROM {$table} WHERE wr_id = '{$_POST['array_id'][$i]}'";
			$sql = "UPDATE {$table} SET wr_4 = '', wr_6 = '취소완료' WHERE wr_id = '{$_POST['array_id'][$i]}'";
			sql_query($sql);
		}
	
	
	
		
	}
}
if ($use_sms) {
	$array_id = $_POST['array_id']; 
	//전화주문은 입력정보들이 없기때문에 array에서 제외시킴

	$count = count($array_id); //unset시 배열 인덱스가 꼬이기 떄문에 선언

	for ($i=0; $i < $count; $i++) { 
		if (strpos($array_id[$i], "un")!==false) {
			unset($array_id[$i]);
		}elseif (strpos($array_id[$i], "null")!==false) {
			unset($array_id[$i]);
		}
	}

	$array_id = array_values($array_id);
	$result = array();
	
	$sms = new SendSMS();

	 for ($i=0; $i < count($array_id); $i++) { 
		$sql = "SELECT * FROM $table WHERE wr_id = '{$array_id[$i]}'";
		$result[$i] = sql_fetch($sql);

		$sms->setSMS($result[$i]);
		$sms->send();
	 	
	}
}
?>
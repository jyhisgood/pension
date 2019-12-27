<?php 
 include_once('./_common.php');
 
 


if ($_POST['status'] == 'seasonInsert') {
	//공백 언더바 처리
	$_POST['date_name'] = preg_replace("/\s+/", "_", $_POST['date_name']);


	// 기간추가
	meta_update(array(
		"mta_db_table"=>"date/config",
		"mta_db_id"=>$_POST['date_name'],
		"mta_key"=>$_POST['start_date'],
		"mta_value"=>$_POST['end_date'])
	);
	
	$_POST['id'] = sql_insert_id();


// 기간수정	
}elseif ($_POST['status'] == "seasonUpdate") {


	// 띄어쓰기 구분
	$_POST['date_name'] = preg_replace("/\s+/", "_", $_POST['date_name']);


	$sql = "SELECT mta_db_id FROM {$g5['meta_table']} WHERE mta_idx = '{$_POST['id']}'";
	$result = sql_fetch($sql);


	//************설정에 있는 정보 업데이트*************
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_db_id = '{$_POST['date_name']}',
					mta_key   = '{$_POST['start_date']}',
					mta_value = '{$_POST['end_date']}'
				WHERE mta_idx = '{$_POST['id']}'";
	sql_query($sql);


	//************  객실에 등록된 시즌 가격 이름 수정 (WEEKDAY)  *************
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekday{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekday{$result['mta_db_id']}'";
	sql_query($sql);


	//************  객실에 등록된 시즌 가격 이름 수정 (WEEKEND)  *************
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekend{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekend{$result['mta_db_id']}'";
	sql_query($sql);


	//************  객실에 등록된 시즌 가격 이름 수정 (WEEKEND2)  *************
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekend2{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekend2{$result['mta_db_id']}'";
	sql_query($sql);

	
	
// 기간삭제
}elseif ($_POST['status'] == "seasonDelete") {

	// 객실에 남아있는 잔여 시즌 가격 정보들을 조회하기 위한 SELECT QUERY

	$sql = "SELECT mta_db_id FROM g5_5_meta WHERE mta_idx = '{$_POST['id']}'";
	$fetch = sql_fetch($sql);

	// 삭제 할 시즌 이름
	$willDeleteSeasonName = $fetch['mta_db_id'];
	
	// 설정에 있는 시즌 정보 삭제
	$sql = "DELETE FROM {$g5['meta_table']} WHERE mta_idx = '{$_POST['id']}'";
	sql_query($sql);


	// 객실에 있는 시즌 가격정보 삭제
	$sql = "DELETE FROM {$g5['meta_table']} WHERE mta_db_table = 'board/yp_pension01' AND mta_key LIKE '%{$willDeleteSeasonName}%'";
	sql_query($sql);


}elseif ($_POST['status'] == "closeRoom") {
	// 방막기 기간 추가
	if ($_POST['route'] == "reg") {
		meta_update(array(
			"mta_db_table"=>"closed/".$_POST['bo_table'],
			"mta_db_id"=>'closed',
			"mta_key"=>$_POST['start_date'],
			"mta_value"=>$_POST['end_date'])
		);
	}elseif ($_POST['route'] == "update") {
		$sql = " UPDATE {$g5['meta_table']} SET 
							mta_key   = '{$_POST['start_date']}',
							mta_value = '{$_POST['end_date']}'
						WHERE mta_idx = '{$_POST['id']}'";
		sql_query($sql);

	}elseif ($_POST['route'] == "delete") {
		$sql = "delete from {$g5['meta_table']} where mta_idx = '{$_POST['id']}'";
		sql_query($sql);
	}
	
}




echo json_encode($_POST); 
?>
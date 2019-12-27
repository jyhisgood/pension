<?php 
include_once('./_common.php');


if($_POST['status'] == 'remove_holi'){
	$sql = "DELETE FROM {$g5['meta_table']} WHERE mta_db_id = 'holiday' AND mta_key = '{$_POST['name']}' AND mta_value = '{$_POST['date']}'";
	sql_query($sql);



}elseif($_POST['status'] == 'reg_holi'){

	meta_update(array(
		"mta_db_table"=>"holi/".$_POST['bo_table'],
		"mta_db_id"=>'holiday',
		"mta_key"=>$_POST['name'],
		"mta_value"=>$_POST['date'])
	);

}elseif ( $_POST['status'] == 'date_insert' ) {
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
	
}elseif ($_POST['status'] == "date_update") {
	$_POST['date_name'] = preg_replace("/\s+/", "_", $_POST['date_name']);
	$sql = "SELECT mta_db_id FROM {$g5['meta_table']} WHERE mta_idx = '{$_POST['id']}'";
	$result = sql_fetch($sql);

	// 기간수정
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_db_id = '{$_POST['date_name']}',
					mta_key   = '{$_POST['start_date']}',
					mta_value = '{$_POST['end_date']}'
				WHERE mta_idx = '{$_POST['id']}'";
	sql_query($sql);

	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekday{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekday{$result['mta_db_id']}'";
	sql_query($sql);

	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekend{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekend{$result['mta_db_id']}'";
	sql_query($sql);
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekend2{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekend2{$result['mta_db_id']}'";
	sql_query($sql);

	
	
}elseif ($_POST['status'] == "date_delete") {

	// 기간삭제
	$sql = "delete from {$g5['meta_table']} where mta_idx = '{$_POST['id']}'";
	sql_query($sql);


}elseif ($_POST['status'] == "settings") {
	
	$bo_table = $_POST['bo_table'];
	$bo_1 = $_POST['bo_1'];
	$bo_2 = $_POST['bo_2'];
	$bo_3 = $_POST['bo_3'];
	$bo_4 = $_POST['bo_4'];
	$bo_1_subj = $_POST['bo_1_subj'];
	$bo_2_subj = $_POST['bo_2_subj'];
	$bo_3_subj = $_POST['bo_3_subj'];
	$bo_4_subj = $_POST['bo_4_subj'];
	$bo_5_subj = $_POST['bo_5_subj'];
	$bo_6_subj = $_POST['bo_6_subj'];
	$bo_7_subj = $_POST['bo_7_subj'];
	$bo_8_subj = $_POST['bo_8_subj'];
	$bo_9_subj = $_POST['bo_9_subj'];
	$bo_10_subj = $_POST['bo_10_subj'];
	if ($_POST['chk_SMS'] == "false") {
		$bo_5 = "";
	}else{
		$bo_5 = $_POST['bo_5'];
		
	}
	$bo_6 = $_POST['bo_6'];
	$bo_7 = $_POST['bo_7'];
	$bo_8 = $_POST['bo_8'];
	$bo_9 = $_POST['bo_9'];
	$bo_10 = $_POST['bo_10'];
	$sql = "delete FROM {$g5['meta_table']} WHERE mta_db_table = 'settings/{$bo_table}'";
	sql_query($sql);
	for ($i=0; $i < count($_POST['settings_meta']); $i++) { 
		meta_update(
			array("mta_db_table"=>"settings/".$bo_table,
	     		  "mta_db_id"=>$_POST['settings_meta'][$i][0], 
	     		  "mta_key"=>$_POST['settings_meta'][$i][1], 
	     		  "mta_value"=>$_POST['settings_meta'][$i][3])
		);
	}
	// $msg = $sql;
	
	 
	
	
	$sql = "UPDATE {$g5['board_table']} SET bo_2 = '{$bo_2}',
											bo_3 = '{$bo_3}',
											bo_4 = '{$bo_4}',
											bo_5 = '{$bo_5}',
											bo_6 = '{$bo_6}',
											bo_7 = '{$bo_7}',
											bo_8 = '{$bo_8}',
											bo_9 = '{$bo_9}',
											bo_1_subj = '{$bo_1_subj}',
											bo_2_subj = '{$bo_2_subj}',
											bo_3_subj = '{$bo_3_subj}',
											bo_4_subj = '{$bo_4_subj}',
											bo_5_subj = '{$bo_5_subj}',
											bo_6_subj = '{$bo_6_subj}',
											bo_7_subj = '{$bo_7_subj}',
											bo_8_subj = '{$bo_8_subj}',
											bo_9_subj = '{$bo_9_subj}',
											bo_10_subj = '{$bo_10_subj}',
											bo_10 = '{$bo_10}'

										WHERE bo_table = '{$bo_table}'";
	sql_query($sql);
	$sql = "UPDATE {$g5['board_table']} SET bo_2 = '{$bo_9}',
											bo_3 = '{$bo_4}',
											bo_1_subj = '{$_POST['pay_for_pet']}',
											bo_2_subj = '{$bo_2_subj}',
											bo_3_subj = '{$bo_3_subj}',
											bo_4_subj = '{$bo_4_subj}',
											bo_5_subj = '{$bo_5_subj}',
											bo_6_subj = '{$bo_6_subj}',
											bo_7_subj = '{$bo_7_subj}',
											bo_8_subj = '{$bo_8_subj}',
											bo_9_subj = '{$_POST['mail_user_chk']}',
											bo_10_subj = '{$_POST['mail_adm_chk']}',
											bo_4 = '{$bo_10}',
											bo_5 = 'no',
											bo_9 = '{$_POST['mail_id']}',
											bo_8 = '{$_POST['mail_pass']}',
											bo_7 = '{$_POST['mail_text2']}',
											bo_6 = '{$_POST['mail_text']}',
											bo_10 = '{$_POST['is_mail']}'
										WHERE bo_table = '{$bo_1}'";
	sql_query($sql);

	$sql = "UPDATE {$g5['config_table']} SET cf_10 = '{$_POST['sms_check']}',
											 cf_1_subj = '{$_POST['chk_resev_ready_adm']}',
											 cf_2_subj = '{$_POST['chk_resev_ready_user']}',
											 cf_3_subj = '{$_POST['chk_resev_compl_adm']}',
											 cf_4_subj = '{$_POST['chk_resev_compl_user']}',
											 cf_5_subj = '{$_POST['chk_resev_cancel_req_adm']}',
											 cf_6_subj = '{$_POST['chk_resev_cancel_req_user']}',
											 cf_7_subj = '{$_POST['chk_resev_cancel_res_adm']}',
											 cf_8_subj = '{$_POST['chk_resev_cancel_res_user']}',
											 cf_1 = '{$_POST['msg_resev_ready_adm']}',
											 cf_2 = '{$_POST['msg_resev_ready_user']}',
											 cf_3 = '{$_POST['msg_resev_compl_adm']}',
											 cf_4 = '{$_POST['msg_resev_compl_user']}',
											 cf_5 = '{$_POST['msg_resev_cancel_req_adm']}',
											 cf_6 = '{$_POST['msg_resev_cancel_req_user']}',
											 cf_7 = '{$_POST['msg_resev_cancel_res_adm']}',
											 cf_8 = '{$_POST['msg_resev_cancel_res_user']}'";
	sql_query($sql);


}elseif ($_POST['status'] == "close_reg") {
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
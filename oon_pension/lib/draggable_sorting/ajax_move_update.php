<?php
include_once("./_common.php");

if ($_POST['route'] == "chan") {
	//순서 바꾸기

	$sql = "SELECT wr_num,wr_id FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_id = '{$_POST['checked_id'][0]}'";	
	$first_value = sql_fetch($sql);

	$sql = "SELECT wr_num,wr_id FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_id = '{$_POST['checked_id'][1]}'";	

	$second_value = sql_fetch($sql);

	if (isset($second_value)) {
		$sql1 = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$second_value['wr_num']}' WHERE wr_id = '{$first_value['wr_id']}'";

		sql_query($sql1);

		$sql2 = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$first_value['wr_num']}' WHERE wr_id = '{$second_value['wr_id']}'";

		sql_query($sql2);
	}
	
}elseif ($_POST['route'] == "prev") {

	//앞으로 이동
	$where_clause1 = "<";
	$where_clause2 = "DESC";
	
}elseif ($_POST['route'] == "next") {

	//뒤로 이동
	$where_clause1 = ">";
	$where_clause2 = "ASC";
	
}


//앞으로이동,뒤로이동 쿼리

if (isset($where_clause1)) {
	$sql = "SELECT wr_num,wr_id FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_id = '{$_POST['checked_id'][0]}'";
	$first_value = sql_fetch($sql);

	$sql = "SELECT wr_num,wr_id FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_num {$where_clause1} {$first_value['wr_num']} order by wr_num {$where_clause2} LIMIT 1";

	$second_value = sql_fetch($sql);
	
	if (isset($second_value)) {
		$sql1 = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$second_value['wr_num']}' WHERE wr_id = '{$first_value['wr_id']}'";

		sql_query($sql1);

		$sql2 = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$first_value['wr_num']}' WHERE wr_id = '{$second_value['wr_id']}'";

		sql_query($sql2);
	}
}
	
//댓글 순서 변경

$sql = "SELECT wr_parent,wr_id FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_is_comment = '1'";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
	$sql = "SELECT wr_num FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_parent = '{$row['wr_parent']}' AND wr_is_comment = '0'";
	$fetch = sql_fetch($sql);
	
	$sql = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$fetch['wr_num']}' WHERE wr_id='{$row['wr_id']}'";
	sql_query($sql);
}


echo json_encode($_POST);
?>
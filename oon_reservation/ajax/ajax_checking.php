<?php 
 include_once('./_common.php');

$search_list = array();
$msg = "false";

$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_1 = '{$_POST['number']}' AND wr_2 = '{$_POST['name']}'";
$result = sql_query($sql);


while ($row = sql_fetch_array($result)) {
	$search_list[] = $row;
}

echo json_encode($search_list);
 ?>
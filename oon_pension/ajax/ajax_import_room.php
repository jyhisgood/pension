<?php
include_once('./_common.php');
$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_id = '{$_POST['id']}'";
$fetch = sql_fetch($sql);
$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$_POST['bo_table']}'AND mta_db_id = '{$_POST['id']}'";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
	$fetch[$row['mta_key']] = $row['mta_value'];
}

//option
$name = array();
$price = array();
$option_array = array();
$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$_POST['bo_table']}'AND mta_db_id = '{$_POST['id']}' AND mta_key LIKE '%wr_option_name%'";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
	$name[] = $row['mta_value'];
}

$fetch['length'] = count($name);
echo json_encode($fetch);
?>
<?php 
include_once('./_common.php');
if ($_POST['sort'] == 'price') {
	$temp = array();
	asort($_POST['temp']);
	foreach ($_POST['temp'] as $key => $value) {
		$temp[] = $key;
	}
	echo json_encode($temp);
	return;
}
$queryResultArray = array();
$searchTable = $g5['write_prefix'].$_POST['bo_table'];
$searchId = "wr_id";
$queryWhere = "";
$queryOrder = $_POST['sort'];

if ($_POST['sort'] != "wr_subject") {
	$searchTable = $g5['meta_table'];
	$searchId = "mta_db_id";
	$queryWhere = "WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND mta_key = '{$_POST['sort']}'";
	$queryOrder = "mta_value";
	if ($_POST['sort'] == "wr_max") {
		$queryOrder .= "+0";
	}
	$queryOrder .= " ".$_POST['order'];
}


$sql = "SELECT * FROM {$searchTable} {$queryWhere} ORDER BY {$queryOrder}";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
	$queryResultArray[] = $row[$searchId];
}

$result = array();
$sortedArray = array_intersect($queryResultArray, $_POST['id']);

foreach ($sortedArray as $key => $value) {
	$result[] = $value;
}

echo json_encode($result);
?>
<?
include_once('./_common.php');

$reservedId = array();
$roomData = array();

$selectedDate = date('Y-m-d', strtotime($_POST['date']));




$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_1']} WHERE wr_4 LIKE '%{$selectedDate}%'";
$result = sql_query($sql);


while ($row = sql_fetch_array($result)) {
	$findRoomWr4 = explode("|", $row['wr_4']);
	$findRoomWr3 = explode("|", $row['wr_3']);
	for ($i=0; $i < count($findRoomWr4); $i++) { 
		if (preg_match('/'.$selectedDate.'/',$findRoomWr4[$i])) {
			$reservedId[] = $findRoomWr3[$i];
		}
	}
}

$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_key = '{$selectedDate}'";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
	$reservedId[] = $row['mta_db_id'];
}


$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} ORDER BY wr_num";
$result = sql_query($sql);


$data  = "<table>";
$data .= "<tr>";
$data .= "<td class='preview'>예약현황</td>";
$data .= "</tr>";
while ($row = sql_fetch_array($result)) {
	$status = 'empty';
	for ($i=0; $i < count($reservedId); $i++) { 
		if ($row['wr_id'] == $reservedId[$i]) {
			$status = 'reserved';
			break;
		}
	}
	
	$data .= "<tr>";
	$data .= 	"<td><span class ='".$status."'>".$row['wr_subject']."</span></td>";
	
	$data .= "</tr>";
}
$data .= "</table>";


echo json_encode($data);
?>


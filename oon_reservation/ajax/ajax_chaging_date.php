<?
include_once('./_common.php');

$target_date = new DateTime($_POST['start_date']);
$pre_date = new DateTime();
$start_cul = abs(floor(($pre_date->format('U') - $target_date->format('U')) / (60*60*24)));
//datepicker 끝 날짜

$start =  strtotime($_POST['start_date']); 
$end = strtotime("+7 day", $start);        
$count_day = 0;
$ss['dt1'] = date("Y-m-d",$start);
$ss['dt2'] = date("Y-m-d",$end);

//관리자 환경설정에서 마감일 설정
$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'settings/{$_POST['bo_1']}' AND mta_db_id = 'setting3'";
$fetch = sql_fetch($sql);

$closedArray = array();

$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'closed/{$_POST['bo_1']}'";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
    $closedArray[] = $row;
}


$abc = array();
$isClosed = false;

while ($start <= $end){        
    $date_count = date("Y-m-d",$start);
    $start = strtotime("+1 day",$start);
    
    for ($h=0; $h < count($closedArray); $h++) { 
        $abc[$count_day]['cr'][] = $date_count;
        $abc[$count_day]['st'][] = $closedArray[$h]['mta_key'];
        $abc[$count_day]['en'][] = $closedArray[$h]['mta_value'];

        if (strtotime($date_count) >= strtotime($closedArray[$h]['mta_key']) && strtotime($date_count) < strtotime($closedArray[$h]['mta_value'])) {
            $isClosed = true;    
            break;        
        }
    }
    if ($isClosed) {

        break;
    }
    

    if ($fetch['mta_key'] == $date_count) {
        $count_day ++;
        break;
    }

    $sql = "SELECT wr_id, wr_4 FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_3 = '{$_POST['id']}' AND wr_4 LIKE '%{$date_count}%'";

     
    $result = sql_query($sql);
    if (sql_fetch_array($result)) {
         break;
    }else{
        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'reserved' AND mta_db_id = '{$id}' AND mta_key LIKE '%{$date_count}%'";
        if (sql_fetch($sql)) {
            break;
        }else{
            $count_day ++;    
        }
    }
    
}
$ss['start_cul'] = $start_cul+1;
$ss['count_day'] = $start_cul+$count_day;

echo json_encode($ss); 
?>
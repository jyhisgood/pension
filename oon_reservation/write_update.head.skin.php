<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$start =  strtotime($start_value); 
       
$end = strtotime('-1 day',strtotime($end_value));



while ($start <= $end){        
	
     
    $value = date("Y-m-d", $start);

    $sql = "SELECT EXISTS (SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_4 LIKE '%{$value}%' AND wr_3 = '{$wr_3}') AS isChk";
    $result = sql_fetch($sql);
    
    if ($result['isChk']) {
    	alert("이미 예약된 객실입니다.","./board.php?bo_table=".$board['bo_1']);
    }
    
    
     
    $start = strtotime("+1 day",$start);

    

}

?>
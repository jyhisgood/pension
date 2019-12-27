<?php
include_once('./_common.php');
if ($_POST['type'] == "del_ghost") {
	$total_list = array();
	$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} order by wr_num";
	$result= sql_query($sql);
	while($row = sql_fetch_array($result)){
		$total_list[$row['wr_id']]=$row;
	}
	$array = @array_values(@array_unique($_POST['is_reserved']));
	for ($i=0; $i < count($array); $i++) { 
		unset($total_list[$array[$i]]);
	}
	
	
	echo json_encode($total_list);
	return;

}else{
	$only_reserved = $_POST['only_reserved'];
	$total_list = array();
	$yymmdd = date('Y-m-d',strtotime($_POST['yymmdd']));
	$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_1']} WHERE wr_4 LIKE '%{$yymmdd}%' ORDER BY wr_3 DESC";
	$result = sql_query($sql);
	$data = array();
	$i = 0;
	// $test = array();
	while ($row = sql_fetch_array($result)) {

		$wr_4Temp  = [];
		$wr_5Temp  = [];
		$wr_9Temp  = [];
		$wr_10Temp = [];

		$wr_3Temp  = explode("|", $row['wr_3']);
		$wr_4Temp  = explode("|", $row['wr_4']);
		$wr_5Temp  = explode("|", $row['wr_5']);
		$wr_9Temp  = explode("|", $row['wr_9']);
		$wr_10Temp = explode("|", $row['wr_10']);
		$countTemp = count($wr_4Temp);
		if (count($wr_4Temp) > 1) {

			for ($u=0; $u < $countTemp; $u++) { 
					
				if (strpos($wr_4Temp[$u], $yymmdd) !== false) {
					
				}else{
					unset($wr_3Temp[$u]);
					unset($wr_4Temp[$u]);
					unset($wr_5Temp[$u]);
					unset($wr_9Temp[$u]);
					unset($wr_10Temp[$u]);
				}
			}
			
			$wr_3Temp = array_values($wr_3Temp);
			$wr_4Temp = array_values($wr_4Temp);
			$wr_5Temp = array_values($wr_5Temp);
			$wr_9Temp = array_values($wr_9Temp);
			$wr_10Temp = array_values($wr_10Temp);
		}

		for ($z=0; $z < count($wr_4Temp); $z++) { 
			$data[$i]['time']   = $yymmdd;
			$data[$i]['name']   = $row['wr_2'];
			$data[$i]['date']   = $wr_4Temp[$z];
			$count = count(explode(";", $wr_4Temp[$z]));
			$data[$i]['date_count']   = $count."박".($count+1)."일";
			$data[$i]['id']     = $wr_3Temp[$z];
			$data[$i]['status'] = $row['wr_6'];
			$data[$i]['wr_id']  = $row['wr_id'];
			$data[$i]['room']   = $wr_5Temp[$z];
			$data[$i]['date_range']   = date("m-d",strtotime($wr_9Temp[$z]))." ~ ".date("m-d",strtotime($wr_10Temp[$z]));
			$data[$i]['is_reserved']   = 1;
			if ($row['wr_6'] == "예약대기") {
		    	$data[$i]['color']   = 'style="background:#949494;"';
		    }elseif ($row['wr_6'] == "예약완료") {
		    	$data[$i]['color']   = 'style="background:#6cc0e5;"';
		    }elseif ($row['wr_6'] == "취소요청") {
		    	$data[$i]['color']   = 'style="background:#ff2b2b;"';
		    }

			$i++;
		}

		
	}

	$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'reserved' AND mta_key = '{$yymmdd}'";
	$result = sql_query($sql);
	while ($row = sql_fetch_array($result)) {
		$fetch = sql_fetch("SELECT wr_subject FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_id = '{$row['mta_db_id']}'");
	    $data[$i]['room']   = $fetch['wr_subject'];
		$data[$i]['time']   = $yymmdd;
	    $data[$i]['name']   = '관리자';
	    $data[$i]['date']   = $row['mta_key'];
	    $data[$i]['date_count'] = "1박2일";
	    $data[$i]['id']     = $row['mta_db_id'];
	    $data[$i]['status'] = $row['mta_value'];
	    $data[$i]['wr_id']  = "un_".$row['mta_idx'];
	    $data[$i]['date_range']   = date("m-d",strtotime($row['mta_key']))." ~ ".date('m-d',strtotime("+1 day", strtotime($row['mta_key'])));
	    $data[$i]['is_reserved']   = 1;
	    if ($row['mta_value'] == "예약대기") {
	    	$data[$i]['color']   = 'style="background:#949494;"';
	    }elseif ($row['mta_value'] == "예약완료") {
	    	$data[$i]['color']   = 'style="background:#6cc0e5;"';
	    }elseif ($row['mta_value'] == "취소요청") {
	    	$data[$i]['color']   = 'style="background:#ff2b2b;"';
	    }
	    
	    $i++;
	}



		
		
	$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} order by wr_num";
	$result= sql_query($sql);

	while($row = sql_fetch_array($result)){

		$check = array();
		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]['id'] == $row['wr_id']) {
				$check = $data[$i];
				
			}

		}
		if (!empty($check)) {
			$total_list[] = $check;
		}elseif($_POST['only_reserved'] !=""){
			$row['time'] = $yymmdd;
			$row['id'] = $row['wr_id'];
			$row['wr_id'] = "null".$row['wr_id'];
			$row['is_reserved'] = 0;
			$row['status'] = "예약가능";
			$total_list[] = $row;
		}

	}

	


	echo json_encode($total_list);
}
?>
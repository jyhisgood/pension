<?
require_once('Seasons.php');
require_once('Holidays.php');
/**
 * Room Data
 */
class Rooms extends Seasons
{
	private $g5;
	private $board;
	public  $season;
	public  $roomId;
	public  $roomTableName;
	public  $roomAllList = array();


	function __construct($bo_table, $wr_id = 0)
	{

		global $g5;
		global $board;

		$this->g5            = $g5;
		
		$this->roomId        = $wr_id;
		
		$fetch = sql_fetch("SELECT * FROM {$this->g5['board_table']} WHERE bo_skin = 'theme/oon_pension'");

		if ($bo_table == $fetch['bo_table']) {
			$this->roomTableName = $bo_table;
			$this->board         = $board;

		}else{

			$newBoard = sql_fetch("SELECT * FROM {$this->g5['board_table']} WHERE bo_table = '{$fetch['bo_table']}'");

			$this->roomTableName = $fetch['bo_table'];
			$this->board         = $newBoard;
		}

	}

	// **************bo_table, wr_id(객실 하나 출력시) 셋팅*****************
	
	function getRoom($id)
	{
		$fetch = sql_fetch("SELECT * FROM {$this->g5['write_prefix']}{$this->roomTableName} WHERE wr_id = '{$id}'");

		$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}'";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result)) {
			$fetch[$row['mta_key']] = $row['mta_value'];
		}

		return $fetch;

	}

	function getRoomList($order = "wr_subject")
	{	

		//전체리스트 가져옴
		$sql = "SELECT * FROM {$this->g5['write_prefix']}{$this->roomTableName} ORDER BY {$order} ASC";
		$result = sql_query($sql);
		while ($row = sql_fetch_array($result)) {
			$this->roomAllList[] = $row;

		}

		// META TABLE 가져옴
		for ($i=0; $i < count($this->roomAllList); $i++) { 
			$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$this->roomAllList[$i]['wr_id']}'";
			$result = sql_query($sql);
			while ($temp = sql_fetch_array($result)) {
				$this->roomAllList[$i][$temp['mta_key']] = $temp['mta_value'];
			}
		}
		
		return $this->roomAllList;
	}

	function searchRooms($startDate, $endDate, $type = "", $listIdArray = "", $selectedCountArray = "")
	{

		$Lists = array();

		$compleateCheckingDateDatas = $this->isHoliday($startDate, $endDate);

		$allRoomDatas = $this->getRoomList();

		$start = strtotime($startDate);
		$end   = strtotime('-1 day', strtotime($endDate));
		$count = 0;

		$dump = $allRoomDatas;

		while ($start <= $end){        
			$value = date('Y-m-d',$start);
			//기간중 유저가 예약한 객실 검색
			$sql = "SELECT * FROM {$this->g5['write_prefix']}{$this->board['bo_1']} WHERE wr_is_comment = '0' AND wr_6 != '취소완료' AND wr_4 LIKE '%{$value}%'";
			$result = sql_query($sql);

			while ($row = sql_fetch_array($result)) {

				if (strpos($row['wr_3'], "|") !== false) {
					$explodeWr_3 = explode("|", $row['wr_3']);
					$explodeWr_4 = explode("|", $row['wr_4']);

					for ($o=0; $o < count($explodeWr_4); $o++) { 

						if (strpos($explodeWr_4[$o], $value) !== false) {
							$Lists[] = $explodeWr_3[$o];		

						}
					}
					
				}else{
					$Lists[] = $row['wr_3'];			
				}
				
				//검색된 객실
				$id = $row['wr_3'];
				$key = array_search($id, array_column($allRoomDatas, 'wr_id'));
				unset($allRoomDatas[$key]);
			}


			//관리자가 전화 및 어플로 예약한 객실 검색
			$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'reserved' AND mta_key='{$value}'";
			$result2 = sql_query($sql);
			while($row2 = sql_fetch_array($result2)){
				if (isset($row2['mta_db_id'])) {
					$Lists[] = $row2['mta_db_id'];
					$id = $row2['mta_db_id'];
				}	
			}
			
			
			
			$start = strtotime("+1 day",$start);
			$count++;	
		}

		//중복값 제거
		$Lists = array_unique($Lists);
		//제거 후 value sorting
		$Lists['reserved'] = array_values($Lists);

		$Lists['list'] = $dump;

		$Lists['total'] = $dump;
		//날짜일수 저장
		$Lists['count'] = $count;

		//성인, 소아, 유아 설정시 방 비활성화
		if ($type == 'count') {
			$roomSelectedCount = array();

			for ($i=0; $i < count($listIdArray); $i++) { 
				$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_key='wr_roomsale' AND mta_db_id = '{$listIdArray[$i]}'";
				$fetch = sql_fetch($sql);
				$roomPrice = $this->getPrice($compleateCheckingDateDatas,$listIdArray[$i]);
				$roomDiscountPrice = $this->getSalePrice($compleateCheckingDateDatas, $fetch['mta_value'], $listIdArray[$i]);
				$selectedCountPrice = $this->getAddPrice($selectedCountArray[0], $selectedCountArray[1], $selectedCountArray[2], $listIdArray[$i]);
				$selectedCountPrice = $selectedCountPrice * count($compleateCheckingDateDatas);
				$roomSelectedCount[$i]['price'] = number_format($selectedCountPrice);	
				$roomSelectedCount[$i]['wr_id'] = $listIdArray[$i];
				$roomSelectedCount[$i]['total'] = number_format($roomPrice - $roomDiscountPrice + $selectedCountPrice);
			}
			
			return $roomSelectedCount;
		}

		for ($i=0; $i < count($Lists['list']); $i++) { 

			$roomPrice = $this->getPrice($compleateCheckingDateDatas, $Lists['list'][$i]['wr_id']);
			$roomDiscountPrice = $this->getSalePrice($compleateCheckingDateDatas, $Lists['list'][$i]['wr_roomsale'], $Lists['list'][$i]['wr_id']);
			$totalPrice = $roomPrice - $roomDiscountPrice;

			$Lists['list'][$i]['price'] = number_format($roomPrice).'원';
			$Lists['list'][$i]['sale'] = number_format($roomDiscountPrice).'원';	
			$Lists['list'][$i]['total'] = number_format($totalPrice).'원';	
		}

		return $Lists;

	}



	//날짜들이 주말인지 평일인지 체크함. -->getSeason에 의존함
	private function getWeek($start_date, $end_date){
		$start = strtotime($start_date); 
		$end = strtotime('-1 day',strtotime($end_date));  
		
		$i = 0;
		while ($start <= $end){        
		     
			if (date("w",$start) == "5" || date("w",$start) == "6") {

			 	if ($this->board['bo_7_subj'] && date("w",$start) == "6") {
			 		$data[$i]['date'] = date("Y-m-d",$start);
				 	$data[$i]['name'] = "wr_weekend2비수기";	
			 	}elseif (date("w",$start) == "5" && $this->board['bo_8_subj'] == 1) {
			 		$data[$i]['date'] = date("Y-m-d",$start);
				 	$data[$i]['name'] = "wr_weekday비수기";
			 	}else{
			 		$data[$i]['date'] = date("Y-m-d",$start);
				 	$data[$i]['name'] = "wr_weekend비수기";	
			 	}

			}else{

				if ($this->board['bo_7_subj'] == "2" && date("w",$start) == "0") {
					$data[$i]['date'] = date("Y-m-d",$start);
				 	$data[$i]['name'] = "wr_weekend3비수기";
				}else{
					$data[$i]['date'] = date("Y-m-d",$start);
				 	$data[$i]['name'] = "wr_weekday비수기";
				}
			 	
			}

		    $start = strtotime("+1 day",$start);
			$i++;
		}
		
		return $data;
	}

	// 시즌정보를 입력함 --> isHoliday에 의존함
	private function getSeason($start_date, $end_date){

		//getWeek 호출
		$week = $this->getWeek($start_date, $end_date);

		//시즌정보
		$dateConfig = $this->getSeasonList($this->g5);


		for ($i=0; $i < count($week); $i++) { 

			for ($j=0; $j < count($dateConfig); $j++) { 

				$start = strtotime($dateConfig[$j]['start_date']);
				$end = strtotime($dateConfig[$j]['end_date']);
				$tartget = strtotime($week[$i]['date']);
				
				if ($start > $tartget || $end < $tartget) {

				}else{

					if (strpos($week[$i]['name'], "weekend")) {

						if (strpos($week[$i]['name'], "weekend2")) {
							$week[$i]['name'] = "wr_weekend2".$dateConfig[$j]['date_name'];

						}elseif (strpos($week[$i]['name'], "weekend3")) {
							$week[$i]['name'] = "wr_weekend3".$dateConfig[$j]['date_name'];

						}else{
							$week[$i]['name'] = "wr_weekend".$dateConfig[$j]['date_name'];
						}
						

					}else{

						$week[$i]['name'] = "wr_weekday".$dateConfig[$j]['date_name'];
					}

					$week[$i]['season'] = $dateConfig[$j]['date_name'];
				}

			}

		}

		return $week;

	}

	function isHoliday($start_date, $end_date){
		
		$week = $this->getSeason($start_date, $end_date);
		if ($this->board['bo_5_subj'] == "") {
			return $week;
		}

		$holidays = new Holidays();


		for ($i=0; $i < count($week); $i++) { 
			// $holi_check = date("Y-m-d",strtotime("+1 day", strtotime($week[$i]['date'])));
			$is_holiday = $holidays->getHolidayWeekend($week[$i]['date']);

			if ($is_holiday) {
				$value_2 = "weekend";

				if($this->board['bo_5_subj'] == "1" || $this->board['bo_7_subj'] == "1"){
					$value_2 = "weekend2";
				}
				$week[$i]['name'] = str_replace('weekday', $value_2, $week[$i]['name']);
			}
		}
		

		return $week;
	}

	function getSalePrice($compleateCheckingDateDatas, $sale, $id){
		
		if ($sale == "") {
			return 0;
		}

		$count = count($compleateCheckingDateDatas);

		if ($count < 2) {
			$sale = 0;
		}elseif ($count == 2) {
			$sql = "SELECT mta_value FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}' AND mta_key = 'wr_roomsale1'";
			$day_sale = sql_fetch($sql);
		}elseif ($count == 3) {
			$sql = "SELECT mta_value FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}' AND mta_key = 'wr_roomsale2'";
			$day_sale = sql_fetch($sql);
		}elseif ($count > 3) {
			$sql = "SELECT mta_value FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}' AND mta_key = 'wr_roomsale3'";
			$day_sale = sql_fetch($sql);
		}

		return $day_sale['mta_value'];
	}

	function getAddPrice($old1, $old2, $old3, $id){
		
		$count = $old1 + $old2 + $old3;
		$price = 0;
		$temp = array();

		$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}'";
		$result = sql_query($sql);
		while ($row = sql_fetch_array($result)) {
			$temp[$row['mta_key']] = $row['mta_value'];
		}
		
		
		if ($count > $temp['wr_min']) {
			while ($old3 > 0) {
				if ($count > $temp['wr_min']) {
					$count --;
					$old3 --;
					$price += $temp['wr_13'];

				}else{
					break;
				}
			}
			while ($old2 > 0) {
				if ($count > $temp['wr_min']) {
					$count --;
					$old2 --;
					$price += $temp['wr_12'];
					// echo $price."2<br>";
				}else{
					break;
				}
			}
			while ($old1 > 0) {
				if ($count > $temp['wr_min']) {
					$count --;
					$old1 --;
					$price += $temp['wr_11'];
					// echo $price."3<br>";
				}else{
					break;
				}
			}
		}

		
		return $price;
	}
	function getPrice($compleateCheckingDateDatas, $id){
		
		$price = 0;

		for ($i=0; $i < count($compleateCheckingDateDatas); $i++) { 
			$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}' AND mta_key = '{$compleateCheckingDateDatas[$i]['name']}'";
			$result = sql_fetch($sql);

			

			//가격,날짜,요일 정보
			if ($result['mta_value']=="") {
				$reple = str_replace($compleateCheckingDateDatas[$i]['season'], '비수기', $compleateCheckingDateDatas[$i]['name']);
				$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}' AND mta_key = '{$reple}'";
				$result = sql_fetch($sql);
			}

			$price = $price + $result['mta_value'];

			$price_data[$i]['price'] = $result['mta_value'];
			$price_data[$i]['date'] = $compleateCheckingDateDatas[$i]['date'];
			$price_data[$i]['name'] = $compleateCheckingDateDatas[$i]['name'];
		}
		
		return $price;

	}

	function getOptionPrice($options, $count, $id){
		$price = 0;

		for ($i=0; $i < count($options); $i++) { 
			$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->roomTableName}' AND mta_db_id = '{$id}' AND mta_key = '{$options[$i]}'";
			$result = sql_fetch($sql);
			$price = $price + ($result['mta_value'] * $count[$i]);
			// $arr[$i]['op_name'] = $options[$i];
			// $arr[$i]['count'] = $count[$i];
		}
		return $price;
	}

}
?>
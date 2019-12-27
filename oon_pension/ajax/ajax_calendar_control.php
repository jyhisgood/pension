<?php
include_once('./_common.php');
include_once('../classes/Holidays.php');

if ($_POST['change']=="prev") {
	$yy_mm = date('Y-m',strtotime("-1 month", strtotime($_POST['yy_mm'])));
}elseif ($_POST['change']=="next") {
	$yy_mm = date('Y-m',strtotime("+1 month", strtotime($_POST['yy_mm'])));
}elseif ($_POST['change']=="current") {
	$yy_mm = date('Y-m');
}

$holiday = new Holidays();
$holidayList = $holiday->getHolidayList($yy_mm);


$timeStamp = strtotime($yy_mm);


// 1. 총일수 구하기
$lastDay = date("t", $timeStamp);

// 2. 시작요일 구하기
$startWeek = date("w", strtotime($yy_mm."-01"));

// 3. 총 몇 주인지 구하기
$totalWeek = ceil(($lastDay + $startWeek) / 7);

// 4. 마지막 요일 구하기
$lastWeek = date('w', strtotime($yy_mm."-".$lastDay));

// 5. 년,월 변수에 넣기

$appendTable['table'] = "";

//마감 기간 쿼리









$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'settings/{$_POST['bo_table']}' AND mta_db_id = 'setting3'";
$fetch = sql_fetch($sql);
if ($fetch['mta_key'] != "") {
	$fetch['mta_key'] = date('Y-m-d', strtotime("+1 day", strtotime($fetch['mta_key'])));
}


//해당기간 막기

$closed = $functions->callMetaTable("closed/{$_POST['bo_table']}", 'closed');
// if (!$fetch) {
// 	$fetch['mta_key'] = date('Y-m-d', strtotime("+5 years",strtotime('Now')));
// }
// 5. 화면에 표시할 화면의 초기값을 1로 설정
$day=1;

// 6. 총 주 수에 맞춰서 세로줄 만들기

// '<table id="cal_tb" style="display:none;">

$appendTable['table'] .= 	
	'<tr id = "table_header">
		<td colspan="2" style="padding-bottom: 26px;text-align: right;"><button class="change_month cal_head" value="<"><i class="far fa-arrow-alt-circle-left fa-lg"></i></button>
	</td>
		<td colspan="3" style="padding-bottom: 26px;"><span class="cal_head">'.date('Y년 n월',$timeStamp).'</span></td>
		<td colspan="2" style="padding-bottom: 26px;text-align: left;"><button class="change_month cal_head" value=">"><i class="far fa-arrow-alt-circle-right fa-lg"></i></button></td>
	</tr>
	<tr id="daily">
		<td>일</td>
		<td>월</td>
		<td>화</td>
		<td>수</td>
		<td>목</td>
		<td>금</td>
		<td>토</td>
	</tr>';

for($i=1; $i <= $totalWeek; $i++){
	$appendTable['table'] .= "<tr class='calendar_day'>";
	 // 7. 총 가로칸 만들기
	for ($j=0; $j<7; $j++){
		

		
		if (!(($i == 1 && $j < $startWeek) || ($i == $totalWeek && $j > $lastWeek))){

            // 12. 오늘 날자면 굵은 글씨
			

			if(strtotime($yy_mm."-".$day) >= strtotime(date('Y-m-j'))){

				//&& strtotime($yy_mm."-".$day) <= strtotime($fetch['mta_key'])  if 삽입


				$num = sprintf('%02d',$day);
				$temp = "";
				$isClosed = "check_day";
				$isClosed2 = "";
				$isClosed3 = "cursor: pointer;";
				///////////////////////////////////////////////////////////////////////////////////////////////
				for ($m=0; $m < count($closed); $m++) { 
					if (strtotime($yy_mm."-".$day) >= strtotime($closed[$m]['mta_key']) && strtotime($yy_mm."-".$day) <= strtotime($closed[$m]['mta_value'])) {
						$isClosed = "";
					}
				}
				

				//설정값에 맞게 설정 날짜까지 마감처리
				if ($fetch['mta_key'] != "") {
					
					if (strtotime($yy_mm."-".$day) <= strtotime($fetch['mta_key'])) {
						
					}else{
						$isClosed = "";
					}
				}
				
				if ($isClosed=="") {
					$isClosed2 = 'closed';
					$isClosed3 = "";
				}
				////////////////////////////////////////////////////////////////////////////////////////////////


				$appendTable['table'] .= "<td id='".$yy_mm.'-'.$num."' class='".$isClosed."' style='".$isClosed3."'>";

				if($j == 0){
	    			//일요일
					$temp .= "<font color='#FF0000' class='content ".$isClosed2."'>";
				}else if($j == 6){
	                // 토요일
					$temp .= "<font color='#0000FF' class='content ".$isClosed2."'>";
				}else{
	                // 평일
					$temp .= "<font color='#000000' class='content ".$isClosed2."'>";
				}



	            // 13. 날자 출력
	            $holidayStyle = "";	
	            if ($holidayList && $isClosed != "") {
                    $key_exist = array_key_exists($yy_mm.'-'.$num,$holidayList);
                    if ($key_exist) {
                    	$holidayStyle = "style='color:red;'";
                    }
                }

				
				if ($isClosed=="") {
					$temp .= "<div ".$holidayStyle.">";	
					$temp .= "마감</div>";
				}else{
					$temp .= "<div ".$holidayStyle." title='1' class='tooltip-class'>";	
					$temp .= $day."</div>";
				}
				

			}else{
				
				$appendTable['table'] .= "<td><font class='content closed'><div>마감</div></font>";
			}

			
			$appendTable['table'] .= $temp;
			$appendTable['table'] .= "</font>";

            // 14. 날자 증가
			$day++;
		}else{
			$appendTable['table'] .= "<td>";		
		}
		
		$appendTable['table'] .= "</td>";
	}
	$appendTable['table'] .= "</tr>";
}
// $appendTable['table'] .= "</table>";

$appendTable['next_month'] = $yy_mm;
echo json_encode($appendTable);
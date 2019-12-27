<?php

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

include_once($board_skin_path."/classes/Holidays.php");


if ($member['mb_level']< 8) {
    alert("권한이 없습니다.");
}

?>
<!-- 달력 출력 start -->




<?

$holidays = new Holidays();




if ($_GET['toYear'] && $_GET['toMonth']) {
    $aaa = $_GET['toYear']."-".$_GET['toMonth'];
        //공휴일 데이터 가져오기



    $set_time1 = date_create("$aaa");
    $set_time = date_format($set_time1,"Y-m");
    $mktime  = strtotime($set_time); 
    $last_day = date("t", $mktime);
    $is_selected = 1;
}else{
    $time2 = date('Y')."-". date('n');
    $set_time = date("Y-m");
    $aaa = $set_time;
    $last_day = date("t", time());


}

$calendar_list = $holidays->getHolidayList($aaa);



// 2. 시작요일 구하기
$start_week = date("w", strtotime(date($set_time)."-01"));

// 3. 총 몇 주인지 구하기
$total_week = ceil(($last_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', strtotime(date($set_time)."-".$last_day));



$dateReformat = date('Y-m',strtotime($aaa));

$qu = "SELECT * FROM g5_write_{$board['bo_1']} WHERE wr_4 LIKE '%{$dateReformat}%'";



$result1 = sql_query($qu);
$i = 0;
while ($row=sql_fetch_array($result1)) {
    // $tempRow = array();
    // $tempRow = explode("|", $row);

    $wr_3Explode = array();
    $wr_4Explode = array();

    $wr_3Explode = explode("|", $row['wr_3']);
    $wr_4Explode = explode("|", $row['wr_4']);
    

    for ($m=0; $m < count($wr_3Explode); $m++) { 
        $res_date[$i]['name'] = $row['wr_2'];
        $res_date[$i]['date'] = $wr_4Explode[$m];

        $res_date[$i]['id'] = $wr_3Explode[$m];
        $res_date[$i]['status'] = $row['wr_6'];
        $res_date[$i]['wr_id'] = $row['wr_id'];
        $res_date[$i]['dt_array'] = explode(';', $wr_4Explode[$m]);
        $res_date[$i]['max'] = count($res_date[$i]['dt_array']);
        if ($row['wr_6']=="예약완료") {
            $color = "#6cc0e5";
        }else if ($row['wr_6']=="예약대기") {
            $color = "#949494";
        }else if ($row['wr_6']=="취소요청") {
            $color = "#ff2b2b";
        }
        $res_date[$i]['color'] = $color;
        $i++;
    }
    
    
    
}

$functions = new Functions();
$reservedArray = $functions->callMetaTable('reserved');

for ($n=0; $n < count($reservedArray); $n++) { 
    $res_date[$i]['name'] = '관리자';
    $res_date[$i]['date'] = $reservedArray[$n]['mta_key'];
    $res_date[$i]['id'] = $reservedArray[$n]['mta_db_id'];
    $res_date[$i]['status'] = $reservedArray[$n]['mta_value'];
    if ($reservedArray[$n]['mta_value']=="예약완료") {
        $color = "#6cc0e5";
    }else if ($reservedArray[$n]['mta_value']=="예약대기") {
        $color = "#949494";
    }else if ($reservedArray[$n]['mta_value']=="취소요청") {
        $color = "#ff2b2b";
    }

    
    $res_date[$i]['color'] = $color;
    $res_date[$i]['wr_id'] = "un_".$reservedArray[$n]['mta_idx'];
    $res_date[$i]['is_admin'] = '1';
    $i++;
}


?>


<?php //include_once($board_skin_path."/modal.skin.php")?>

<?php if ($_GET['toYear']) {
    $aaa = strtotime($aaa);
    $next1 = date('Y', strtotime("+1 month",$aaa));
    $next2 = date('m', strtotime("+1 month",$aaa));

    $prev1 = date('Y', strtotime("-1 month",$aaa));
    $prev2 = date('m', strtotime("-1 month",$aaa));
    $next_href = "<a style='cursor: pointer;color: black;' onclick='prev_month()'><i class='fas fa-angle-left'></i></a>";
    $prev_href = "<a style='cursor: pointer;color: black;' onclick='next_month()'><i class='fas fa-angle-right'></i></a>";
    $calendar_subj_date = date("Y년 n월",$aaa);
    // echo "<a style='cursor: pointer;' onclick='prev_month()'><i class='fas fa-angle-left'></i></a> &nbsp; ".date("Y년 n월",$aaa)." &nbsp; <a style='cursor: pointer;' onclick='next_month()'><i class='fas fa-angle-right'></a>";

}else{
    $aaa = strtotime(date("Y-m-d"));
    $next1 = date('Y', strtotime("+1 month",$aaa));
    $next2 = date('m', strtotime("+1 month",$aaa));

    $prev1 = date('Y', strtotime("-1 month",$aaa));
    $prev2 = date('m', strtotime("-1 month",$aaa));
    $next_href = "<a style='cursor: pointer;color: black;' onclick='prev_month()'><i class='fas fa-angle-left'></i></a>";
    $prev_href = "<a style='cursor: pointer;color: black;' onclick='next_month()'><i class='fas fa-angle-right'></i></a>";
    $calendar_subj_date = date("Y년 n월");
    // echo "<a style='cursor: pointer;' onclick='prev_month()'><i class='fas fa-angle-left'></a> &nbsp; ".date("Y년 n월")." &nbsp; <a style='cursor: pointer;' onclick='next_month()'><i class='fas fa-angle-right'></a>";
}

?>
<div style="float: left;margin-left: 10px;">
    <span style="font-size: 23px;color: #bbb;">관리자 모드</span>
</div>
<div style="float: right;">
<div class="boxes header visible-button" style="background: none;padding-top: 4px;padding-bottom: 4px;">
    <input type="checkbox" value="1" id="visible-button">
    <label for="visible-button" id="visible-button-label" style="font-weight: bold;">예약현황 보기</label>
</div>
</div>
<table class="calendar-lib-class" style="display: none;">
    <tr>
        <th colspan="7">
            
            <div style="float: right;">
            <div class="boxes header" style="background: none;padding-top: 4px;padding-bottom: 4px;">
                <input type="checkbox" value="1" id="display-can-reserve">
                <label for="display-can-reserve"> 예약가능한 객실 보기 </label>
            </div>
            </div>
        </th>
    </tr>
     <tr>
        <th colspan="7" class="calendar-head" style="padding-bottom: 15px;">
            <span style="width: 19%;" class="tb-head-date" id="prev-val" data-prev1="<?=$prev1?>" data-prev2="<?=$prev2?>" ><?=$next_href?></span>
            <span style="width: 59%;" class="tb-head-date" id="set-time" data-setTime="<?=$set_time?>"><?=$calendar_subj_date?></span>
            <span style="width: 19%;" class="tb-head-date" id="next-val" data-next1="<?=$next1?>" data-next2="<?=$next2?>" ><?=$prev_href?></span>
        </th>
    </tr>
    <tr>
        <td class="day-name">일</td>
        <td class="day-name">월</td>
        <td class="day-name">화</td>
        <td class="day-name">수</td>
        <td class="day-name">목</td>
        <td class="day-name">금</td>
        <td class="day-name">토</td>
    </tr>
    
    <?// 6. 총 주 수에 맞춰서 세로줄 만들기
    $day=1;

    $chk_day=1;
    for($i=1; $i <= $total_week; $i++){
        echo "<tr class='reserve-status'>";
        for ($j=0; $j < 7; $j++) { 

            // 14. 날자 증가

            $bbb = $set_time."-".$chk_day;

            $set_date_time = date('Y-m-d',strtotime($bbb));

            if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){
                $today = "";
                if($set_date_time == date("Y-m-d")){
                    $today = "today";
                }
                echo '<td class="day '.$today.'"><span class="number">'.$day.'</span>';
                

               /////////////공휴일 출력///////////
                $mk_day = sprintf('%02d',$day);
                $is_same = $set_time."-".$mk_day;
                if ($calendar_list) {
                    $key_exist = array_key_exists($is_same,$calendar_list);
                    if ($key_exist) {
                        echo "<span class='number' style='float: right; margin: 0; padding-right: 10%; color: #bd0000;height: 15px;' data-toggle='tooltip' data-placement='bottom' title='".$calendar_list[$is_same]->name."'><i class='fas fa-circle'></i></span>";
                        
                    }
                }
                /////////////공휴일 출력///////////
                for ($k=0; $k<count($total_list); $k++) {
                    $reserved[0] = false;
                    $class = "event";

                    for ($z=0; $z < count($res_date); $z++) { 
                        // echo $res_date[$z]['date'];
                        // echo "<br>";
                        // echo $set_date_time;
                        if (strpos($res_date[$z]['date'], $set_date_time) !== false && $res_date[$z]['id']==$total_list[$k]['wr_id']) {
                            $reserved[0] = true;
                            $reserved[1] = $res_date[$z]['name'];   
                            $reserved[2] = $res_date[$z]['color'];
                            $reserved[3] = $res_date[$z]['wr_id'];
                            
                            if ($res_date[$z]['max'] > 1) {
                                end($res_date[$z]['dt_array']);
                                

                                if (array_search($set_date_time, $res_date[$z]['dt_array']) == 0) {
                                    $class = "event event-multiday-start";
                                }elseif (array_search($set_date_time, $res_date[$z]['dt_array']) != 0 && array_search($set_date_time, $res_date[$z]['dt_array']) != key($res_date[$z]['dt_array'])) {
                                    $class = "event event-multiday";
                                }else{
                                    $class = "event event-multiday-finish";
                                }
                                
                            }
                        }



                    }

                    //상태바 찍기
                    if ($reserved[0]) {
                        echo "<span class='".$class." long' style='background-color:".$reserved[2].";display:none;' name='". $total_list[$k]['wr_id'] ."' data-reserve-id='".$reserved[3]."'>".$reserved[1]."</span>";
                    }else{
                        echo '<span class="event event-ghost" name="'.$total_list[$k]['wr_id'].'" style="display:none;">&nbsp;</span>';
                    }    
                        

                }

                
                echo "</td>";
                $chk_day++;
                $day++;
            }else{
                echo '<td></td>';
            }

        }
        echo "</tr>";


        echo '<tr class="append-data">
                <td colspan="7" class="checked-day-info" >
                    <div style="position:relative;">
                        <div class="arrow" style="display:none;"></div>
                    </div>
                             
                </td>
              </tr>';

    }?>
   
</table>
    

            

<!-- 달력출력 end -->

<script type="text/javascript" src="<?=$board_skin_url?>/js/calendar/adminReservationManaging.js"></script>
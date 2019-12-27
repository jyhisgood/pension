<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/default.php");
include_once(PENSION_SKIN_PATH."/classes/Rooms.php");
include_once(PENSION_SKIN_PATH."/classes/SendSMS.php");

//달력 예약된방 체크

$wr_3 = explode("|", $wr_3);
$encodeArray = array();
$objectRooms = new Rooms($bo_table);
for ($k=0; $k < count($start_value); $k++) { 
    $getSeason = $objectRooms->isHoliday($start_value[$k], $end_value[$k]);

    $new_array = array();
    $price_array = array();

    //new_array
    for ($i=0; $i < count($getSeason); $i++) { 
        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$wr_3[$k]}' AND mta_key = '{$getSeason[$i]['name']}' AND mta_db_table = 'board/{$board['bo_1']}'";
        $val = sql_fetch($sql);
        
        //시즌 금액이 없다면 비수기 가격으로 계산
        if ($val['mta_value'] == "") {
            $getSeason[$i]['name'] = str_replace($getSeason[$i]['season'], '비수기', $getSeason[$i]['name']);
            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$wr_3[$k]}' AND mta_key = '{$getSeason[$i]['name']}' AND mta_db_table = 'board/{$board['bo_1']}'";
            $val = sql_fetch($sql);
        }
        $getSeason[$i]['price'] = $val['mta_value'];
        if ($getSeason[$i]['season']) {

            $new_array[$getSeason[$i]['season']][] = $getSeason[$i];

        }else{
            $new_array['비수기'][] = $getSeason[$i];
        }
        
    }
    //price_array
    foreach ($new_array as $key => $value) {
        $price = 0;
        for ($i=0; $i < count($new_array[$key]); $i++) { 
            $price += $new_array[$key][$i]['price'];
        }
        $new_array[$key]['price'] = $price;
    }
    $encodeArray[] = $new_array;
    

    /////options/////
    for ($u=0; $u < count($options[$k]); $u++) { 
        if ($options[$k][$u][2] != "0") {
            $sql = " INSERT INTO g5_pension_options SET 
                            op_wr_id = '{$wr_id}',
                            op_key   = '{$wr_3[$k]}',
                            op_name  = '{$options[$k][$u][0]}',
                            op_price = '{$options[$k][$u][1]}',
                            op_count = '{$options[$k][$u][2]}',
                            op_reg_dt = '".G5_TIME_YMDHIS."'";    

            sql_query($sql);
        }
    }
    
    
    
}
// print_r2($encodeArray);
// exit;
$encode = json_encode($encodeArray,JSON_UNESCAPED_UNICODE);



$startDateArray    = implode("|", $start_value);
$endDateArray      = implode("|", $end_value);
$total_price       = implode("|", $total_price);
$calendar_counting = implode('|', $calendar_counting);
$animals_price     = implode("|", $animals_price);



meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>'wr_animals',"mta_value"=>$animals_price));


$wr_old1 = implode("|", $countOld1);
meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>'wr_old1',"mta_value"=>$wr_old1));
$wr_old2 = implode("|", $countOld2);
meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>'wr_old2',"mta_value"=>$wr_old2));
$wr_old3 = implode("|", $countOld3);
meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>'wr_old3',"mta_value"=>$wr_old3));

$wr_animals2 = implode("|", $animalsCount);
meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>'wr_animals2',"mta_value"=>$wr_animals2));


$sql = "update $write_table set 
                                wr_4 = '{$calendar_counting}',
                                wr_7 = '{$encode}', 
                                wr_9 = '{$startDateArray}',
                                wr_8 = '{$total_price}',
                                wr_10 = '{$endDateArray}'
                                where wr_id = '{$wr_id}'";
sql_query($sql);


//메세지 발송용 변수 정의
$sendArr = array();
$sendArr['wr_6'] = $wr_6;
$sendArr['wr_2'] = $wr_2;
$sendArr['wr_5'] = $wr_5;
$sendArr['wr_1'] = $wr_1;
$sendArr['wr_8'] = $total_price;
$sendArr['wr_9'] = $startDateArray;
$sendArr['wr_10'] = $endDateArray;

$sms = new SendSMS();
$sms->setSMS($sendArr);
$sms->send();

// for ($i=0; $i < count($list); $i++) { 
    
    // break;
    // print_r2($sms);
// }

//이메일 발송
if ($board['bo_10'] == '1') {
    include_once(G5_LIB_PATH.'/mailer.lib.php');

    $sql = "SELECT * FROM {$g5['config_table']}";
    $fetch = sql_fetch($sql);

    if ($board['bo_10_subj']=="1") {        
        //사용자
        $wr_name = $fetch['cf_title'];
        $wr_email = $board['bo_7']; 
        $email = $wr_mail;
        $subject= $fetch['cf_title']." 예약 객실 안내"; 
        $link = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr;
        $board['bo_6'] = str_replace('{name}', $wr_2, $board['bo_6']);
        $board['bo_6'] = str_replace('{date}', $start_value.'~'.$end_value, $board['bo_6']);
        $board['bo_6'] = str_replace('{price}', $wr_8, $board['bo_6']);
        $board['bo_6'] = str_replace('{link}', "<br><a href='".$link."'>내 예약페이지 바로가기</a>", $board['bo_6']);
        $content=nl2br($board['bo_6']);
        mailer($board['bo_9'],$board['bo_8'],$email,$subject,$content);
    }
    if ($board['bo_9_subj']=="1") {
        //어드민
        $email = $fetch['cf_admin_email'];
        $subject= $fetch['cf_title']." 예약 객실 안내";
        $link = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr;

        $board['bo_7'] = str_replace('{name}', $wr_2, $board['bo_7']);
        $board['bo_7'] = str_replace('{date}', $start_value.'~'.$end_value, $board['bo_7']);
        $board['bo_7'] = str_replace('{price}', $wr_8, $board['bo_7']);
        $board['bo_7'] = str_replace('{link}', "<br><a href='".$link."'>내 예약페이지 바로가기</a>", $board['bo_7']);
        $content=nl2br($board['bo_7']);

        mailer($board['bo_9'],$board['bo_8'],$email,$subject,$content);   
    }
}

?>
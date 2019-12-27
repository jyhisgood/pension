<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/default.php");
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/write.css">', 1);

include_once($board_skin_path."/reserve/includeForWrite.php");
include_once(PENSION_SKIN_PATH."/classes/Seasons.php");

//아이디 복사
$temp_id = $id;

$postWrId = implode("|", $id);



?>

<h2 class="reservAccountTitle1" style="text-align:center;">
    <span class="highlight"></span> 
    <span class="highlight1">예약 하기</span> 
    
</h2>
    
<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="wr_subject" value="객실 예약">
    <input type="hidden" name="wr_content" value="-">
    <input type="hidden" name="wr_6" value="예약대기">
    <input type="hidden" name="wr_3" value = "<?php echo $postWrId?>">
    <!-- <input type="hidden" name="wr_8" value = "<?php if($wr_8){echo $wr_8;}else{echo '0원';}?>" id="total_price"> -->
    
    <input type="hidden" name="wr_name" value="user">
    
    <!-- <input type="hidden" name="wr_4" value="" id="calendar_counting"> -->
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice">공지</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html">html</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= PHP_EOL.'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;

    


    ?>




    <table class="table write-class">
        
        <tbody>

            <div class="info" style="padding-bottom:5px;">
                <div style="/*border: 1px solid black;*/padding: 10px;background: #ddd;" class="agree-div">
                    <h4><label><input type="checkbox" name="chk_agree1" class="check_agree"> 개인정보 동의서</label> 
                        <div style="float: right;"> 
                            <span id="agree1" style="cursor: pointer;">내용보기</span> 
                        </div>
                    </h4>
                </div>
                <div class="scr" id="scr1" style="display: none;">
                    <?php echo nl2br($agree['bo_7'])?><br/>
                </div>
                
            </div>
            <div class="info" style="padding-bottom:5px;">
                <div style="padding: 10px;background: #ddd;" class="agree-div">
                    <h4><label><input type="checkbox" name="chk_agree2" class="check_agree"> 환불 및 취소 안내</label>
                        <div style="float: right;">
                            <span id="agree2" style="cursor: pointer;">내용보기</span>
                        </div>
                    </h4>
                </div>
                <div class="scr" id="scr2" style="display: none;">
                    <?php echo nl2br($agree['bo_8'])?><br/>
                </div>
                
            </div>
            <div class="info" style="padding-bottom:5px;">
                <div style="padding: 10px;background: #ddd;" class="agree-div">
                    <h4><label><input type="checkbox" name="chk_agree3" class="check_agree"> 입퇴실 규정 동의서</label>
                        <div style="float: right;">
                            <span id="agree3" style="cursor: pointer;">내용보기</span>
                        </div>
                    </h4>
                </div>
                <div class="scr" id="scr3" style="display: none;">
                   <?php echo nl2br($agree['bo_6'])?><br/>
                </div>
                
            </div>
            <div class="info" style="border-bottom:1px solid #ddd;padding-bottom: 30px;">
                <div style="padding: 10px;background: #ddd;" class="agree-div">
                    <h4><label><input type="checkbox" id="check_all"> 전체 동의합니다.</label>
                    </h4>
                </div>
            </div>

            <?php if ($is_category) { ?>
            <tr>
                <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
                <td>
                    <select class="form-control" style="width:120px; display: inline-table;" id="ca_name" name="ca_name" required>
                        <option value="">선택하세요</option>
                        <?php echo $category_option ?>
                    </select>
                </td>
            </tr>
            <?php } ?>


            <tr>
                <th scope="row"><label for="wr_2"><span style="color: red;">*</span>예금주명<strong class="sound_only">필수</strong></label></th>
                <td><input type="text" name="wr_2" value="<?php echo $wr_2 ?>" id="wr_2" required class="frm_input required" maxlength="20" placeholder="예약자명과 동일합니다."> </a></td> 
            </tr>
            <tr>
                <th scope="row"><label for="wr_1"><span style="color: red;">*</span>연락처</label></th>
                <td>
                    <span style="display: inline-block;"><input placeholder="ex) 01012345678" type="text" name="wr_1" value="<?php echo $write['wr_1'] ?>" id="wr_1" required class="frm_input required" size="25" maxlength="11"></span>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="wr_email">이메일</label></th>
                <td>
                    <span style="display: inline-block;"><input type="text" name="wr_mail" class="frm_input"></span>
                </td>
            </tr>
            <?php if ($settingsArray['setting1'] == "1"): ?>
                <tr>
                    <th scope="row"><label for="wr_parking">예약자 차량번호</label></th>
                    <td>
                        <div style="font-size: 13px; color: red; font-weight: bold; margin-bottom: 6px;">
                            *차량이 1대 이상일 경우 콤마(,)로 구분해주세요.
                        </div>
                        <div>
                            <input type="text" name="wr_parking" class="frm_input">
                        </div>
                    </td>
                </tr>
            <?php endif ?>
            <?php if ($settingsArray['setting2'] == "1"): ?>
                <tr>
                    <th scope="row"><label for="wr_intime">입실 예상시간</label></th>
                    <td>
                        <div>
                            <input type="text" name="wr_intime" class="frm_input">
                        </div>
                    </td>
                </tr>
            <?php endif ?>
            <?php if ($board['bo_6_subj']) {?>
            <tr>
                <th scope="row"><label for="wr_pickup">픽업 <input type="checkbox" name="wr_pickup" value="1" id="wr_pickup"></label></th>
                <td>
                    <div id="pickup_content">
                        픽업 요청시 체크박스를 클릭해주세요.
                    </div>
                    
                </td>
            </tr>
            <?php }?>
            <?php if ($member['mb_level'] >= 8) {?>
            <tr>
                <th scope="row"><label for="wr_pickup">SMS 사용여부</label></th>
                <td>
                    <input type="radio" checked="checked" name="smscheck" value=""> 사용&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="smscheck" value="1"> 사용안함
                    
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    <div class="multi-reserve-container">

    <?for ($z=0; $z < count($temp_id); $z++) { 
        $id = $temp_id[$z];
        $booking_tb = $functions->callBo1Table($id, true);
        $wrSubjectArray[] = $booking_tb['wr_subject'];

        ?>
    
    <div class="multi-reserve-wrap <?=$z?>" data-wrid="<?=$booking_tb['wr_id']?>">
        <div class="info multi-reserve-tab">
            <div class="multi-reserve-tab-child">
                <h4 class="room-name" style="float: left;"> <label><?=$booking_tb['wr_subject']?></label></h4>
                <h4 class="room-name check-submit" style="display: none;"><i class="fas fa-check" style="float: right;margin-right: 8px; font-size: 20px; "></i></h4>
            </div>
        </div>
        <div class="multi-reserve-contents">
            <table class="table write-class">
                <tbody>
            <tr class="room-sale" data-room-sale="<?=$booking_tb['wr_roomsale']?>">   
                <input type="hidden" name="total_price[]" value="" class="total_price">
                <input type="hidden" name="animals_price[]" value="" class="animals_price">
                <input type="hidden" name="calendar_counting[]" value="" class="calendarCounting">
                <?php 
                //숙박기간 시작 제한날짜 계산
                //예약자가 에약한 객실 불러옴
                $sql = "SELECT wr_4 FROM $write_table WHERE wr_3 = {$id} AND wr_6 != '취소완료'";
                $result = sql_query($sql);
                $reserved = array();
                
                while ($row = sql_fetch_array($result)) {
                    if (strpos($row['wr_4'], ";") !== false) {

                        $dividing = explode(";", $row['wr_4']);

                        for ($i=0; $i < count($dividing); $i++) { 
                            $before = strtotime($dividing[$i]);
                            $reserved[]= date("Y-n-j", $before);

                        }

                    }else{

                        $before = strtotime($row['wr_4']);
                        $reserved[]= date("Y-n-j", $before);


                    }
                    
                    
                }
                //관리자가 예약한 객실 불러옴
                $reservedThisRoom = $functions->callMetaTable('reserved', $id);
                for ($i=0; $i < count($reservedThisRoom); $i++) { 
                    $before = strtotime($reservedThisRoom[$i]['mta_key']);
                    $reserved[] = date("Y-n-j", $before);
                }
                
                //관리자가 방 막은 셋팅 가져옴

                $reservedThisRoom = $functions->callMetaTable('closed/'.$board['bo_1'], 'closed');
                for ($i=0; $i < count($reservedThisRoom); $i++) { 
                    $start =  strtotime($reservedThisRoom[$i]['mta_key']); 
                    $end = strtotime($reservedThisRoom[$i]['mta_value']);   

                    while ($start <= $end){        

                        $reserved[] = date("Y-n-j",$start);
                        
                        $start = strtotime("+1 day",$start);
                        
                        
                    }
                }
                
                if ($reserved== "") {
                    $reserved = array();
                }
                
                // datepicker 시작날짜

                if ($reservation_date!="") {


                    $target_date = new DateTime($reservation_date);
                    $pre_date = new DateTime();
                    $start_cul = abs(floor(($pre_date->format('U') - $target_date->format('U')) / (60*60*24)));
                    
                    //datepicker 끝 날짜
                    
                    $start =  strtotime($reservation_date); 
                    $end = strtotime("+7 day", $start);        
                    $count_day = 0;

                    while ($start <= $end){        
                         $date_count = date("Y-m-d",$start);
                         $start = strtotime("+1 day",$start);

                         $sql = "SELECT wr_id, wr_4 FROM $write_table WHERE wr_3 = '{$id}' AND wr_4 LIKE '%{$date_count}%'";

                         
                         $result = sql_query($sql);
                         if (sql_fetch_array($result)) {
                             break;
                         }else{
                            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'reserved' AND mta_db_id = '{$id}' AND mta_key LIKE '%{$date_count}%'";
                            if (sql_fetch($sql)) {
                                break;
                            }else{

                                $count_day ++;  
                                if ($start >= strtotime("+1 day", strtotime($closed_setting)) && $closed_setting != "") {break;}
                            }
                            
                        }
                        
                    }
                    $start_cul_array[] = $start_cul;
                    $end_range_array[] = $start_cul+$count_day;
                    $reserved_array[] = $reserved;
                    
                    
                }?>
                <th><span style="color: red;">*</span>숙박기간</th>
                <td>
                    <div style="padding-bottom: 12px;">
                    <div class="rest_date">입실 날짜</div> <input type="text" class="frm_input required wr_4" name="start_value[]" onchange="chang_start(this.value, true)" value="<?php if($wr_9){echo $wr_9;}else{echo $reservation_date;} ?>" readonly data-roomst="<?=$booking_tb['wr_roomstdate']?>"></div>
                    <div>
                    <div class="rest_date">퇴실 날짜 </div><input type="text" class="frm_input required wr_5" name="end_value[]" onchange="getPriceJs('change')" value = "<?php if($wr_10){echo $wr_10;}else{echo $end_date;}?>" readonly data-roomen="<?=$booking_tb['wr_roomendate']?>">
                    </div>
                </td>
            </tr>    
            <tr>
                <th scope="row"><span style="color: red;">*</span>인원</th>
                <td class="counting-max" data-max-checking="<?=$booking_tb['wr_max']?>">
                    <div style="color: red; font-size: 14px; font-weight: bold; margin-bottom: 5px;">
                         - 기준(<?php echo $booking_tb['wr_min']?>명) 최대(<?php echo $booking_tb['wr_max']?>명)
                    </div>
                    <div class = "select_count">
                        성인
                        <?php
                        if ($wr_add1) {
                            $is_add1 = $wr_add1;
                        }else{
                            $is_add1 = $booking_tb['wr_min'];
                        }
                        ?>
                        <select onchange="getPriceJs()" name="countOld1[]" class="sel wr_old1">
                            <?php for ($i=0; $i <= $booking_tb['wr_max']; $i++) { ?>
                            <option <?php if ($is_add1 == $i) {echo "selected";}?> value="<?=$i?>"><?=$i?></option>
                            <?php }?>
                        </select>
                    </div>
                    <?php if ($board['bo_2_subj']!=""): ?>
                            
                        
                    <div class = "select_count">
                    소인
                    <select onchange="getPriceJs()" name="countOld2[]" class="sel wr_old2" data-toggle="tooltip" title="<?=$board['bo_3_subj']?"{$board['bo_3_subj']}세 이상은 소인에 해당됩니다":""?>">
                        <?php for ($i=0; $i <= $booking_tb['wr_max']; $i++) { ?>
                        <option <?php if ($wr_add2 == $i) {echo "selected";}?> value="<?=$i?>"><?=$i?></option>
                        <?php }?>
                    </select>
                 
                    </div>
                    <div class = "select_count">
                    유아
                        <select onchange="getPriceJs()" name="countOld3[]" class="sel wr_old3" data-toggle="tooltip" title="<?=$board['bo_3_subj']?"{$board['bo_3_subj']}세 미만은 유아에 해당됩니다.":""?>">
                            <?php for ($i=0; $i <= $booking_tb['wr_max']; $i++) { ?>
                                <option <?php if ($wr_add3 == $i) {echo "selected";}?> value="<?=$i?>"><?=$i?></option>
                            <?php }?>
                        </select>
                        <?php if ($board['bo_4_subj']!=""): ?>
                            <label style="font-size: 17px;width: 24px;background: black;border-radius: 26px;text-align: center;color: white;margin-left: 9px;" data-toggle="tooltip" title="<?=$board['bo_4_subj'].'개월 미만의 유아는 추가요금이 발생하지 않습니다.'?>">?</label>
                        <?php endif ?>
                    </div>

                    <?php endif ?>

                </td>
                
            </tr>
            <?php if ($board['bo_1_subj'] != ""): ?>
            <tr>
                <th scope="row"><label for="wr_options">애완동물</label></th>
                <td>
                    <div class = "select_count">
                        <select name="animalsCount[]" id="wr_animals" class="sel wr_animals2" onchange="getPriceJs()"> 
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        마리 1박당 <?=$board['bo_1_subj']?>원 추가
                    </div>
                </td>
            </tr>
            <?php endif ?>
            
            <?php 
            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/".$board['bo_1']."' and mta_db_id  = '".$id."' AND mta_key LIKE '%wr_option_name%' ORDER BY mta_key asc";
            $result = sql_query($sql);
            $option_array = array();
            
            $j = 0;
            
            while ($row = sql_fetch_array($result)) {
                $option_array[$j]['op_name'] = $row['mta_value'];
                
                $j++;
            }
            $j = 0;
            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/".$board['bo_1']."' and mta_db_id  = '".$id."' AND mta_key LIKE '%wr_option_price%' ORDER BY mta_key asc";
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                $option_array[$j]['op_price'] = $row['mta_value'];
                $option_array[$j]['op_key'] = $row['mta_key'];
                $j++;
            }
            if (!empty($option_array)) {?>
            <tr>
                <th scope="row"><label for="wr_options">옵션<strong class="sound_only">필수</strong></label></th>
                <td>
                    <table class="option_tbl">
                    <?                    
                    for ($i=0; $i < count($option_array); $i++) { ?>
                        <tr>
                            <td><?php echo $option_array[$i]['op_name']?></td>
                            <td style="width: 25% !important;"><?php echo number_format($option_array[$i]['op_price'])?>원</td>
                            <td style="height: 33px;">
                                <label for="" style="font-weight: unset;">
                                <input type="hidden" name="options[<?=$z?>][<?=$i?>][]" value="<?=$option_array[$i]['op_name']?>">
                                <input type="hidden" name="options[<?=$z?>][<?=$i?>][]" value="<?=$option_array[$i]['op_price']?>">
                                <input type="text" class="frm_input required amount" data-opname="<?= $option_array[$i]['op_key']?>" onkeyup="getPriceJs()" name="options[<?=$z?>][<?=$i?>][]" value="<?php if($write[$option_array[$i]['op_key']]){echo $write[$option_array[$i]['op_key']];}else{echo '0';}?>" style="width: 50px;height: 28px;" >개</label>
                            </td>
                        </tr>
                        
                    <?php }?>

                    </table>
                </td>

            </tr>   
            <?}?>

            

            <tr>
                <td colspan="2">
                    <div style="text-align: center;">
                        <input type="button" value="완료" class="submit-btn-reserve">
                    </div>
                </td>
            </tr>
                </tbody>
            </table> 
        </div>
    </div>
    <?php }?>
    </div>
    <!-- <div class="multi-reserve-wrap">
        <div class="multi-reserve-tab"></div>
        <div class="multi-reserve-contents"></div>
    </div>
    -->
    <table class="table write-class">
        <tbody>
            
            <tr>
                <td colspan="2" style="padding-top: 35px;">
                    <div class="aa">
                        <div class="selected_info">선택객실정보
                            <span class="reserve_date">
                                없음
                            <span>
                        </div>
                        <div class="tb_div">
                            <table class="room_data">
                                <tr>
                                    <th>객실명</th>
                                    <td id="this-room-name">객실을 선택해주세요</td>
                                </tr>
                                <tr>
                                    <th>입실시간<br>퇴실시간</th>
                                    <td id = "this-room-in-out-time">
                                        <div><span id="this-room-in-time">객실을 선택해주세요.</span></div>
                                        <div><span id="this-room-out-time">객실을 선택해주세요.</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>총 가격</th>
                                    <td><span id="this-room-price">객실을 선택해주세요.</span></td>
                                </tr>
                                
                            </table>

                        </div>
                    </div>
                    
                    <div class="bb">
                    
                        <div class="tb_price_div">
                            <table class="tb_price">
                                
                                <tr>
                                    <td style="width: 40%;">객실 금액</td>
                                    <td style="width: 20%;">-</td>
                                    <td style="width: 40%;"><span id="room_price">+0원</span></td>
                                </tr>
                                <tr>
                                    <td>연박 할인</td>
                                    <td>-</td>
                                    <td><span id="room_sale_price">-0원</span></td>
                                </tr>
                                <tr>
                                    <td>추가 인원</td>
                                    <td>-</td>
                                    <td><span id="county_price">+0원</span></td>
                                </tr>
                                <?php if ($board['bo_1_subj'] != ""): ?>
                                <tr>
                                    <td>애완동물 추가가격</td>
                                    <td>-</td>
                                    <td><span id="animals_price">+0원</span></td>
                                </tr>
                                <?php endif ?>
                                <tr>
                                    <td>옵션 금액</td>
                                    <td>-</td>
                                    <td><span id="op_price">+0원</span></td>
                                </tr>
                                
                                <tr style="border-top: 1px solid #ddd !important;">
                                    <td style="border-top: 1px solid #ddd;">총 결제금액</td>
                                    <td style="border-top: 1px solid #ddd;">-</td>
                                    <td style="border-top: 1px solid #ddd;"><span id="sum_price"><?php if($wr_8){echo $wr_8;}else{echo '0원';}?></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            

            <?php if ($is_guest) { //자동등록방지 ?>
            <tr>
                <th scope="row">자동등록방지</th>
                <td>
                    <?php echo $captcha_html ?>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>
    <section id="bo_w">
        <div class="btn_confirm">
            <input type="submit" value="예약하기" id="btn_submit" class="btn_submit" accesskey="s">
            <a href="./board.php?bo_table=<?php echo $board['bo_1'] ?>" class="btn_cancel">취소</a>
        </div>
    </section>
    <?$wrSubjectArray = implode("|", $wrSubjectArray)?>
    <input type="hidden" name="wr_5" value="<?=$wrSubjectArray?>">
</form>

<script>
    
var closed_setting    = "<?=$closed_setting?>";    
var is_search         = "<?=$wr_add1?>";    
var disabledDaysArray = <?php echo json_encode($reserved_array)?>;
var start_cul_array   = <?php echo json_encode($start_cul_array)?>;
var end_range_array   = <?php echo json_encode($end_range_array)?>;    

<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
}); 

<?php } ?>
function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{
    var rtnVal = true;
    $('.multi-reserve-tab').each(function(index, el) {
        if ($(this).hasClass('submited-this-room') === false) {
            rtnVal = false;
        }
    });
    if (!rtnVal) {
        alert("객실 선택후 완료 버튼을 눌러주세요.");
        return false;
    }

    <?php// echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    // if (document.getElementById("char_count")) {
    //     if (char_min > 0 || char_max > 0) {
    //         var cnt = parseInt(check_byte("wr_content", "char_count"));
    //         if (char_min > 0 && char_min > cnt) {
    //             alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
    //             return false;
    //         }
    //         else if (char_max > 0 && char_max < cnt) {
    //             alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
    //             return false;
    //         }
    //     }
    // }
    
    if (!f.chk_agree1.checked || !f.chk_agree2.checked || !f.chk_agree3.checked){
        alert("개인정보 사항에 체크하셔야 합니다.");
        f.chk_agree1.focus();
        return false;
    }
    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
<script type="text/javascript" src="<?=$board_skin_url?>/js/write.js"></script>
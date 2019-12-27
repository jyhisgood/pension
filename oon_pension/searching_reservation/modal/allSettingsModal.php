<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
    #settings label {font-weight: unset;}
</style>
<!-- 환경설정 -->
<div class="modal fade" id="settings" role="dialog">
    <div class="modal-dialog" style="z-index: 9999;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5><i class="fa fa-list" aria-hidden="true"></i>환경설정</h5>
            </div>
            <div class="modal-body tbl_head01 tbl_wrap" style="overflow: auto;">


                <?
                $sql = "SELECT * FROM {$g5['board_table']} WHERE bo_table = '{$board['bo_1']}'";
                $fetch = sql_fetch($sql);
                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'settings/{$bo_table}'";
                $result = sql_query($sql);
                // echo $sql;
                $settings_array = array();
                while ($row = sql_fetch_array($result)) {
                    $settings_array[$row['mta_db_id']] = $row['mta_key'];
                }
                ?>


                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">기본설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">입금계좌설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">예약동의란</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-sms-tab" data-toggle="pill" href="#pills-sms" role="tab" aria-controls="pills-sms" aria-selected="false">SMS발송설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-mail-tab" data-toggle="pill" href="#pills-mail" role="tab" aria-controls="pills-mail" aria-selected="false">메일발송설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-holiday-tab" data-toggle="pill" href="#pills-holiday" role="tab" aria-controls="pills-holiday" aria-selected="false">공휴일관리</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="pills-options-tab" data-toggle="pill" href="#pills-options" role="tab" aria-controls="pills-options" aria-selected="false" onclick="widthImport()">객실공통옵션</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#pills-setting" role="tab" aria-controls="pills-setting" aria-selected="false">초기환경설정</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table>
                            <tr>
                                <th style="text-align: center;">예약 제한 날짜 설정</td>
                                <td>
                                    <div style="display: inline;position: relative;">
                                        <input type="text" class="frm_input input03"  id="setting3" value="<?=$settings_array['setting3']?>" data-name="setting3"  style="width: 130px" readonly="readonly">
                                         <i class="fas fa-times-circle" id="clean-setting3" style="font-size: 21px; vertical-align: middle; position: absolute; right: 10px; top: -1px;"></i>
                                    </div>까지만 예약을 받습니다.
                                    
                                </td>

                            </tr>
                            <tr>

                                <th style="text-align: center;">예약 대기시간</td>
                                <td>
                                    <input type="text" class="frm_input input03" name="bo_2" value="<?php echo $board['bo_2'];?>" style="width: 50px"> 시간 뒤 예약취소
                                </td>
                            </tr>
                            <tr style="display: none;">
                                <th style="text-align: center;">달력 예약완료 노출명 선택</td>
                                <td>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "") {echo "checked";}?> value=""> 모든이름 &nbsp;&nbsp;ex)홍길동<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "1") {echo "checked";}?> value="1"> 중간이름 &nbsp;&nbsp;ex)O길O<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "2") {echo "checked";}?> value="2"> 성만 노출 &nbsp;ex)홍OO<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "3") {echo "checked";}?> value="3"> 마지막이름 ex)OO동<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "4") {echo "checked";}?> value="4"> 객실명 ex)객실 101호

                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">소인/유아 인원 포함 여부</th>
                                <td>
                                    <input type="radio" name ="bo_2_subj" <?php if ($board['bo_2_subj'] == "") {echo "checked";}?> value=""> 성인만 사용
                                    <br>
                                    <input type="radio" name ="bo_2_subj" <?php if ($board['bo_2_subj'] == "1") {echo "checked";}?> value="1"> 성인/소인/유아 구별
                                    
                                </td>
                            </tr>
                            <tr id="kids" style="display: none;">
                                
                                <td colspan="2">
                                    ※ 아래 내용을 작성하시면 사용자가 예약할 때 출력됩니다.<br>
                                    <input type="text" class="frm_input input03"  name="bo_3_subj" required value="<?echo $board['bo_3_subj']?>" style="height: 25px;width: 50px">세 이상은 소인으로, 미만은 유아로 취급합니다.<br>
                                    <input type="text" class="frm_input input03"  name="bo_4_subj" value="<?echo $board['bo_4_subj']?>" style="height: 25px;width: 50px">개월 이하의 유아는 기준인원에 포함하지 않음.<br>
                                    <font color="red">*모든 연령의 유아를 포함한다면 빈칸으로 작성해주세요.</font>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;"><label>애완동물 허용 <input type="checkbox" id="is_pay_for_pet" <? if($fetch['bo_1_subj'] != "") echo "checked";?>></label></th> 
                                <td>
                                    <label>1마리 1박당 <input type="text" class="frm_input" style="width: 150px;" id="pay_for_pet" value="<?=$fetch['bo_1_subj']?>">원</label>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">공휴일 전날 <br>주말요금 적용 여부
                                </th> 
                                <td>
                                    <label><input type="radio" name ="bo_5_subj" <?php if ($board['bo_5_subj'] == "1") {echo "checked";}?> value="1"> 사용</label>
                                    <label><input type="radio" name ="bo_5_subj" <?php if ($board['bo_5_subj'] == "") {echo "checked";}?> value=""> 사용안함</label>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">금요일 주말적용 여부</th> 
                                <td>
                                    <label><input type="radio" name ="bo_8_subj" <?php if ($board['bo_8_subj'] == "") {echo "checked";}?> value=""> 금,토 주말가격 적용</label>
                                    <label><input type="radio" name ="bo_8_subj" <?php if ($board['bo_8_subj'] == "1") {echo "checked";}?> value="1"> 토요일만 주말가격 적용</label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th style="text-align: center;"><label>예약자 차량번호<br>입력란 생성 여부 <input type="checkbox" id="setting1" value="1" data-name="setting1" <?if ($settings_array['setting1'] == '1') echo "checked"; ?>></label></th> 
                                <td>
                                    <div>예약자가 예약할 때 가져올 차량번호를 작성할 수 있는 작성란이 생깁니다.<br>ex) 12가3456,78나9123 ...</div>

                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;"><label>예약자 입실 예정시간<br>입력란 여부 <input type="checkbox" id="setting2" value="1" data-name="setting2" <?if ($settings_array['setting2'] == '1') echo "checked"; ?>></label></th> 
                                <td>
                                    <div>예약자가 예약할 때 입실예정시간을 작성할수있습니다.<br>ex) 오전 10시 50분쯤</div>

                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">주말 가격 구분 여부</th> 
                                <td>
                                    <label><input type="radio" name ="bo_7_subj" <?php if ($board['bo_7_subj'] == "") {echo "checked";}?> value=""> 금,토 주말가격 일괄적용</label>
                                    <label><input type="radio" name ="bo_7_subj" <?php if ($board['bo_7_subj'] == "1") {echo "checked";}?> value="1"> 금,토 가격 구분</label>
                                    <label><input type="radio" name ="bo_7_subj" <?php if ($board['bo_7_subj'] == "2") {echo "checked";}?> value="2"> 금,토,일 가격 구분</label>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">픽업옵션 사용여부</th>
                                <td>
                                    <input type="radio" name ="bo_6_subj" <?php if ($board['bo_6_subj'] != "") {echo "checked";}?> value="1"> 사용
                                    <input type="radio" name ="bo_6_subj" <?php if ($board['bo_6_subj'] == "") {echo "checked";}?> value=""> 사용안함
                                </td>
                            </tr>
                            
                            <tr id="pick_up" <?if (!$board['bo_6_subj']) {echo 'style="display: none;"';}?>>
                                <th style="text-align: center;">픽업시 유의사항<br>(요금, 장소, 시간 등)</th>
                                <td>
                                    <input class="frm_input input03" style="width: 100%;"  name="bo_6_subj_content" id="bo_6_subj_content" value="<?php echo $board['bo_6_subj'];?>">
                                </td>
                                   
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table>
                            <tr>
                                <th style="text-align: center;">입금 계좌정보</td>
                                <td>
                                    <?if ($config['cf_escrow']) {?>
                                        <table>
                                            <tr>
                                                <th>은행명</td>
                                                <td><input type="text" class="frm_input input03"  name="bo_4" value="<?php echo $board['bo_4'];?>"></td>
                                            </tr>
                                            <tr>
                                                <th>계좌 번호</td>
                                                <td><input type="text" class="frm_input input03"  name="bo_9" value="<?php echo $board['bo_9'];?>"></td>
                                            </tr>
                                            <tr>
                                                <th>예금주</td>
                                                <td><input type="text" class="frm_input input03"  name="bo_10" value="<?php echo $board['bo_10'];?>"></td>
                                            </tr>
                                        </table>    
                                    <? }else{?>
                                         <span style="color: red;">에스크로 등록하셔야 계좌설정이 가능합니다</span> <br> 관리자에 관리/설정->기본환경설정->에스크로설정<br>
                                            
                                         <a href="<?php echo G5_USER_ADMIN_URL.'/config_form.php#anc_cf_escrow' ?>" style="background: red; color: white;">에스크로 등록하기</a>
                                        
                                    <? }?>
                                    
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <table>
                            <tr>
                                <th style="text-align: center;">입퇴실 규정 추가</th>
                                <td colspan="2"><textarea class="frm_input input03" style="height: 100px;width: 100%;"  name="bo_6"><?php echo $board['bo_6'];?></textarea></td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">개인정보활용 추가</th>
                                <td colspan="2"><textarea class="frm_input input03" style="height: 100px;width: 100%;" name="bo_7"><?php echo $board['bo_7'];?></textarea></td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">환불규정 추가</th>
                                <td colspan="2"><textarea class="frm_input input03" style="height: 100px;width: 100%;" name="bo_8"><?php echo $board['bo_8'];?></textarea></td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-sms" role="tabpanel" aria-labelledby="pills-sms-tab">
                        <?php
                        $sql = "SELECT * FROM {$g5['config_table']}";
                        $result = sql_fetch($sql);
                        
                        ?>
                        <table id="tb_sms">
                            <thead>
                                <tr>
                                    <th colspan="3">SMS발송 메세지 여부 및 문구 설정</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <b>[TIP] 발송 여부 및 문구 설정시</b><br><br>
                                        <span style="color:red;">
                                        ※ 전송내용에 있는 각 변수 들은 {name}: 예약자, {date}: 숙박날짜,{room}: 방이름, {price}: 예약금액입니다. <br>
                                        ※ 변수 이외의 문구들은 직접 설정이 가능합니다. <br>
                                        ※ SMS 서비스는 80 byte 길이 까지만 지원합니다. (한글 기준 약 40자) <br><br>
                                        </span>
                                        ex) [관리자] {name}님 {room} {date} 예약이 접수되었습니다. {price}을 입금해주세요 <br>
                                             [사용자] {name}님 {room} {price} 입금 확인되어 예약접수 완료 공지사황 확인 부탁드립니다.<br>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th>SMS 발송 여부</th>
                                    <td colspan="2">
                                        
                                        80byte 이상은 LMS로 전환되어 발송됩니다.<br>
                                        SMS : 1건소모 / LMS 6건 소모<br>
                                        
                                        <select id="sms_check" class="sel" style="float: none;padding-top: 7px;">
                                            <option value="" <?if($result['cf_10']==""){echo "selected";}?>>사용안함</option>
                                            <option value="1" <?if($result['cf_10']=="1"){echo "selected";}?>>유플러스</option>
                                            <option value="2" <?if($result['cf_10']=="2"){echo "selected";}?>>아이코드</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="sms_tr">
                                    <th>예약요청시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_ready_adm" <?php if ($result['cf_1_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_ready_adm" class="frm_input input03" style="height: 70px;" style="height: 70px;"><?php if ($result['cf_1']=="") {
                                            // echo "{name}님이 {date} {room}에 예약하셨습니다. 객실금액 : {price}";
                                            echo "[관리자] 예약요청되었습니다.";
                                            }else{ 
                                                echo $result['cf_1'];
                                            }?></textarea>
                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_ready_user" <?php if ($result['cf_2_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_ready_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_2']=="") {
                                            // echo "{name}님 {date} {room}에 예약이 접수되었습니다. {price}을 입금하면 완료처리 됩니다.";
                                            echo "[예약자] 예약요청되었습니다.";
                                            }else{ 
                                                echo $result['cf_2'];
                                            }?></textarea>
                                    </td>
                                </tr>
                                <tr class="sms_tr">
                                    <th>예약완료시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_compl_adm" <?php if ($result['cf_3_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_compl_adm" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_3']=="") {
                                            // echo "{name}님이 {date} {room} {price} 입금 확인되어 예약완료했습니다.";
                                            echo "[관리자] 입금이 확인되어 예약완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_3'];
                                            }?></textarea>

                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_compl_user"<?php if ($result['cf_4_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_compl_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_4']=="") {
                                            // echo "{name}님 {date} {room} {price}이 입금 확인되어 예약완료되었습니다.";
                                            echo "[예약자] 입금이 확인되어 예약완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_4'];
                                            }?></textarea>
                                    </td>
                                </tr>
                                <tr class="sms_tr">
                                    <th>취소요청시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_cancel_req_adm"<?php if ($result['cf_5_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_req_adm" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_5']=="") {
                                            // echo "{name}님이 {date} {room} 취소요청을 하셨습니다.";
                                            echo "[관리자] {name}님이 취소요청을 하셨습니다.";
                                            }else{ 
                                                echo $result['cf_5'];
                                            }?></textarea>
                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_cancel_req_user"<?php if ($result['cf_6_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_req_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_6']=="") {
                                            // echo "{name}님 {date} {room} 취소요청 되었습니다.";
                                            echo "[예약자] 취소요청 되었습니다.";
                                            }else{ 
                                                echo $result['cf_6'];
                                            }?></textarea>
                                </td>
                                </tr>
                                <tr class="sms_tr">
                                    <th>취소완료시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_cancel_res_adm" <?php if ($result['cf_7_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_res_adm" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_7']=="") {
                                            // echo "[{name}님 {date} {room}] 취소완료되었습니다.";
                                            echo "[관리자] 취소완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_7'];
                                            }?></textarea>
                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_cancel_res_user" <?php if ($result['cf_8_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_res_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_8']=="") {
                                            // echo "{name}님 {date} {room} 취소완료되었습니다.";
                                            echo "[예약자] 취소완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_8'];
                                            }?></textarea>
                                    </td>
                                </tr>    
                                
                            </tbody>

                            
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-mail" role="tabpanel" aria-labelledby="pills-mail-tab">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="3">이메일 발송 여부 및 문구 설정</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <span style="color:red;">
                                        ※ 네이버 아이디와 비밀번호를 정확하게 입력해주세요.<br>
                                        ※ 변수 이외의 문구들은 직접 설정이 가능합니다. <br>
                                        ※ {name} >> 예약자명, {room} >> 객실명, {date} >> 기간,<br>
                                        ※ {price} >> 가격, {link} >> 예약확인 링크
                                        </span>
                                    </td>
                                    
                                </tr>
                                
                                <tr>
                                    
                                    <th colspan="2">
                                        예약시 이메일 발송 여부
                                        <select id="email_check" class="sel" style="float: none;padding-top: 7px;">
                                            <option <?if($fetch['bo_10']==""){echo "selected";}?> value="">사용안함</option>
                                            <option <?if($fetch['bo_10']=="1"){echo "selected";}?> value="1">사용</option>
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">발신명</th>
                                    <td style="width: 75%;"><input type="text" class="frm_input input03" name="mail_id" value="<?=$fetch['bo_9']?>"></td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">발송 이메일주소</th>
                                    <td style="width: 75%;"><input type="text" class="frm_input input03" name="mail_pass" value="<?=$fetch['bo_8']?>"></td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2">
                                        발송 메세지 입력
                                        <table>
                                            <tr>
                                                <td style="width: 50%;">

                                                    관리자 <input type="checkbox" id="admin_email" value="1" <?if ($fetch['bo_10_subj']) {echo "checked";}?> ><br>
<textarea class="frm_input input03" style="height: 150px;width: 100%" name="mail_text2"><?if($fetch['bo_7']){echo $fetch['bo_7'];}else{echo "{name}님 {date} 날짜로 예약이 신청되었습니다.
자세한 내용은 아래에 링크를 통해 예약을 확인해주세요.
{link}";}?></textarea>
                                                </td>
                                                <td style="width: 50%;">
                                                    사용자 <input type="checkbox" id="user_email" value="1" <?if ($fetch['bo_9_subj']) {echo "checked";}?> ><br>
<textarea class="frm_input input03" style="height: 150px;width: 100%" name="mail_text"><?if($fetch['bo_6']){echo $fetch['bo_6'];}else{echo "{name}님 {date} 날짜로 예약이 신청되었습니다.
자세한 내용은 아래에 링크를 통해 예약을 확인해주세요.
{link}";}?></textarea>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div style="margin-top: 15px;text-align: center;">
                            플러그인 설치시 초기 셋팅을 합니다.<br>
                            <input type="button" value="초기셋팅" id="set-pension" class="btn btn-default" style="margin-top: 10px;">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-holiday" role="tabpanel" aria-labelledby="pills-holiday-tab">
                        <table style=" display: block; height: 500px; overflow-y: scroll;">
                            <thead>
                                <tr>
                                    <th style="width: 40% !important;">공휴일명</th>
                                    <th style="width: 40% !important;">날짜</th>
                                    <th style="width: 20% !important;">관리</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;width: 40% !important;">
                                        <input type="text" class="frm_input input03" id="reg_holiday_name" style="width: 100%;">
                                    </td>
                                    <td style="text-align: center;width: 40% !important;">
                                        <input type="text" class="frm_input input03" id="reg_holiday_date" name="is_date" style="width: 100%;" readonly="readonly">
                                    </td>
                                    <td style="text-align: center;width: 20% !important;">
                                        <input type="button" value="등록" id="reg_holiday_btn" class="btn btn-default">
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>공휴일명</th>
                                    <th>날짜</th>
                                    <th>관리</th>
                                </tr>
                            </thead>
                            <tbody id="holi-list">
                                <?
                                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'holi/{$bo_table}' AND mta_db_id = 'holiday'";
                                $result = sql_query($sql);
                                while ($row = sql_fetch_array($result)) {?>
                                <tr>
                                    <td style="text-align: center;"><span class="holiday-name-span"><?=$row['mta_key']?></span></td>
                                    <td style="text-align: center;"><span class="holiday-date-span"><?=$row['mta_value']?></span></td>
                                    <td style="text-align: center;"><input type="button" value="삭제" class="btn btn-default holi-remove"></td>
                                </tr>    
                                <? }?>
                            </tbody>
                        </table>
                    </div>
                    <style>
                        /*GLOBALS*/
/**{margin:0; padding:0; list-style:none;}
a{text-decoration:none; color:#666;}
a:hover{color:#1bc1a3;}
body, hmtl{background: #ecf0f1; font-family: 'Anton', sans-serif;}


#wrapper{
    width:600px;
    margin:50px auto;
    height:245px;
    position:relative;
    color:#fff;
    text-shadow:rgba(0,0,0,0.1) 2px 2px 0px;    
}

#slider-wrap{
    width:600px;
    height:245px;
    position:relative;
    overflow:hidden;
    background: rosybrown;
}

#slider-wrap ul#slider{
    width:100%;
    height:100%;
    
    position:absolute;
    top:0;
    left:0;     
}

#slider-wrap ul#slider li{
    float:left;
    position:relative;
    width:600px;
    height:245px;   
}

#slider-wrap ul#slider li > div{
    position:absolute;
    //top:20px;
    //left:35px;  
}

#slider-wrap ul#slider li > div h3{
    font-size:25px;
    text-transform:uppercase;   
    text-align: center;
    margin-bottom: 19px;
}

#slider-wrap ul#slider li > div span{
    font-family: Neucha, Arial, sans serif;
    font-size:21px;
}

#slider-wrap ul#slider li img{
    display:block;
    width:100%;
  height: 100%;
}



.btns{
    position:absolute;
    width:50px;
    height:60px;
    top:50%;
    margin-top:-25px;
    line-height:57px;
    text-align:center;
    cursor:pointer; 
    background:rgba(0,0,0,0.1);
    z-index:100;
    
    
    -webkit-user-select: none;  
    -moz-user-select: none; 
    -khtml-user-select: none; 
    -ms-user-select: none;
    
    -webkit-transition: all 0.1s ease;
    -moz-transition: all 0.1s ease;
    -o-transition: all 0.1s ease;
    -ms-transition: all 0.1s ease;
    transition: all 0.1s ease;
}

.btns:hover{
    background:rgba(0,0,0,0.3); 
}

#next{right:-50px; border-radius:7px 0px 0px 7px;}
#previous{left:-50px; border-radius:0px 7px 7px 7px;}
#counter{
    top: 30px; 
    right:35px; 
    width:auto;
    position:absolute;
}

#slider-wrap.active #next{right:0px;}
#slider-wrap.active #previous{left:0px;}



#pagination-wrap{
    min-width:20px;
    margin-top:140px;
    margin-left: auto; 
    margin-right: auto;
    height:15px;
    position:relative;
    text-align:center;
}

#pagination-wrap ul {
    width:100%;
}

#pagination-wrap ul li{
    margin: 0 4px;
    display: inline-block;
    width:5px;
    height:5px;
    border-radius:50%;
    background:#fff;
    opacity:0.5;
    position:relative;
    top:0;
  
  
}

#pagination-wrap ul li.active{
  width:12px;
  height:12px;
  top:3px;
    opacity:1;
    box-shadow:rgba(0,0,0,0.1) 1px 1px 0px; 
}





h1, h2{text-shadow:none; text-align:center;}
h1{ color: #666; text-transform:uppercase;  font-size:36px;}
h2{ color: #7f8c8d; font-family: Neucha, Arial, sans serif; font-size:18px; margin-bottom:30px;} 





#slider-wrap ul, #pagination-wrap ul li{
    -webkit-transition: all 0.3s cubic-bezier(1,.01,.32,1);
    -moz-transition: all 0.3s cubic-bezier(1,.01,.32,1);
    -o-transition: all 0.3s cubic-bezier(1,.01,.32,1);
    -ms-transition: all 0.3s cubic-bezier(1,.01,.32,1);
    transition: all 0.3s cubic-bezier(1,.01,.32,1); 
}


.choice{    
    padding: 3px 7px;
    background: #616161;
    border: 0;
    color: white !important;
    margin-right: 7px;
}

*/
                    </style>
                    <div class="tab-pane fade" id="pills-options" role="tabpanel" aria-labelledby="pills-options-tab">
                        등록된 모든 객실에서 예약자가 선택할 수 있는 옵션을 만듭니다.
                        <span id="console-ud"></span>
                        <div id="wrapper">
                          <div id="slider-wrap" class="active">
                              <ul id="slider">
                                 <li id="chapter1">
                                    <div style="width: 100%;height: 100%;">
                                        <h3 >#1 옵션 타입 지정</h3>
                                        <div style="">
                                            <div style="width: 60%;margin: auto;">
                                                <div style="margin-bottom: 10px;">
                                                    <input type="button" value="선택" class="choice next" data-type="select">
                                                    <select name="" id="">
                                                        <option value="">Test1</option>
                                                        <option value="">Test2</option>
                                                        <option value="">Test3</option>
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 10px;">
                                                    <input type="button" value="선택" class="choice next" data-type="checkbox">
                                                    Test1 <input type="checkbox">
                                                    Test2 <input type="checkbox">
                                                    Test3 <input type="checkbox"> 
                                                </div>
                                                <div style="margin-bottom: 10px;">
                                                    <input type="button" value="선택" class="choice next" data-type="radio">
                                                    Test1 <input type="radio" name="test">
                                                    Test2 <input type="radio" name="test">
                                                    Test3 <input type="radio" name="test">
                                                </div>
                                                <div style="margin-bottom: 10px;">
                                                    <input type="button" value="선택" class="choice next" data-type="text">
                                                    Test1 : <input type="text" style="width: 100px;">  개
                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>                
                                 </li>
                                 
                                 <li id="chapter2">
                                    <div style="width: 100%;height: 100%;">
                                        <h3 >#2 옵션 이름 등록</h3>
                                        <div style="">
                                            <div style="width: 60%;margin: auto;text-align: center;">
                                                <input type="text" class="form-control" style="margin-top: 50px;" id="text-chapter2">
                                                <div style="margin-top: 22px;">
                                                    <input type="button" value="다음" class="choice next" data-type="name" id="btn-chapter2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </li>
                                 
                                 <li id="chapter3">
                                    <div style="width: 100%;height: 100%;">
                                        <h3 >#3 옵션 가격 사용 여부</h3>
                                        <div style="margin-top: 50px;">
                                            <div style="width: 60%;margin: auto;text-align: center;">
                                                <div>
                                                    가격 옵션을 사용하시겠습니까?<br>
                                                    (옵션 선택시 해당 가격이 추가되어 계산됨)
                                                </div>
                                                <div style="margin-top: 22px;">
                                                    <input type="button" value="사용" class="choice next" data-type="Y" >
                                                    <input type="button" value="사용안함" class="choice next" data-type="N">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </li>
                                 
                                 <li id="chapter4">
                                    <div style="width: 100%;height: 100%;">
                                        <h3 >#4 옵션 종류 추가</h3>
                                        <div style="margin-top: 20px;">
                                            <div style="width: 90%;margin: auto;text-align: center;">
                                                <div id="option-form-wrapper" style="    overflow-y: scroll; max-height: 130px;">
                                                    <div style="display: inline-block; margin-bottom: 5px;">
                                                        옵션 이름 : <input type="text" style="width: 100px; border-radius: 7px; border: 0;" name="c_option_name">
                                                        옵션 가격 : <input type="text" style="width: 100px; border-radius: 7px; border: 0;" placeholder="숫자만 입력" name="c_option_price">
                                                    </div>
                                                    <input type="button" value="추가" class="choice" style="position: absolute; margin-left: 12px;" id="add-option-btn">
                                                    
                                                </div>
                                                <div>
                                                    <input type="button" value="다음" class="choice next" id="option_list" style="margin-top: 5px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </li>
                                 
                                 <li id="chapter5">
                                    <div style="width: 100%;height: 100%;">
                                        <h3 >#3 옵션 개수 사용 여부</h3>
                                        <div style="margin-top: 50px;">
                                            <div style="width: 60%;margin: auto;text-align: center;">
                                                <div>
                                                    개수 옵션 기능을 사용하시겠습니까?<br>
                                                    (예약자가 옵션 선택 후 개수를 정할 수 있습니다.)
                                                </div>
                                                <div style="margin-top: 22px;">
                                                    <input type="button" value="사용" class="choice next" data-type="Y" >
                                                    <input type="button" value="사용안함" class="choice next" data-type="N">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </li>
                                 <li id="chapter6">
                                    <div style="width: 100%;height: 100%;">
                                        <h3 >#3 옵션 개수 사용 여부</h3>
                                        <div style="margin-top: 50px;">
                                            <div style="width: 60%;margin: auto;text-align: center;" id="preview-test">
                                                
                                            </div>
                                        </div>
                                    </div>
                                 </li>
                                 
                                 
                              </ul>
                              
                              <!--controls-->
                              <!-- <div class="btns" id="next" ><i class="fa fa-arrow-right"></i></div> -->
                              <div class="btns" id="previous" ><i class="fa fa-arrow-left"></i></div>
                              <div id="counter"></div>
                              <!-- 
                              <div id="pagination-wrap">
                                <ul>
                                </ul>
                              </div> -->
                              <!--controls-->  
                                     
                          </div>
  
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <!-- <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button> -->
                <button id="settings" type="button" class="btn btn-default" onclick="bo_set()" style="float: right;">완료</button>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript" src="<?=$board_skin_url?>/js/calendar/allSettingsModal.js"></script>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style>
    .add_price{
        font-size: 12px;
    }
</style>
<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'] ?></h2>

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
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        // if ($is_notice) {
        //     $option .= PHP_EOL.'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice">공지</label>';
        // }

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
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo $g5['title'] ?></caption>
        <input type="button" value="객실 불러오기" class="btn btn-primary btn-xs" style="width: 100px;" id="import_booking">
        <tbody>

        <?php if ($option) { ?>
        <tr>
            <th scope="row">옵션</th>
            <td><?php echo $option ?></td>
        </tr>
        <?php } ?>

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

        <!-- <?php if ($is_name) { ?>
        <tr>
            <th scope="row"><label for="wr_name">이름<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" maxlength="20"></td>
        </tr>
        <?php } ?>

        <?php if ($is_password) { ?>
        <tr>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
        </tr>
        <?php } ?>

        <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td><input type="email" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" maxlength="100"></td>
        </tr>
        <?php } ?>

        <?php if ($is_homepage) { ?>
        <tr>
            <th scope="row"><label for="wr_homepage">홈페이지</label></th>
            <td><input type="url" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input"></td>
        </tr>
        <?php } ?> -->






        <tr>
            <th scope="row"><label for="wr_subject">객실명<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required"></td>
        </tr>
        <tr>
            <th scope="row"><label for="wr_area">평 수<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_area" style="width:200px;" value="<?php echo $write['wr_area'] ?>" id="wr_area" required class="frm_input required only-number" placeholder="숫자만입력하세요"></td>
        </tr>


        <tr>
            <th scope="row"><label for="wr_roomstdate">입실시간 / 퇴실시간</label></th>
            <td><input type="text" name="wr_roomstdate" style="width:100px;" value="<?php echo $write['wr_roomstdate'] ?>" id="wr_roomstdate" class="frm_input"> / 
            <input type="text" name="wr_roomendate" style="width:100px;" value="<?php echo $write['wr_roomendate'] ?>" id="wr_roomendate" class="frm_input"></td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_renum">기준인원 / 최대인원</label></th>
            <td><input type="text" name="wr_min" style="width:122px;" value="<?php echo $write['wr_min'] ?>" id="wr_min" class="frm_input only-number" placeholder="숫자만입력하세요"> / 
            <input type="text" name="wr_max" style="width:122px;" value="<?php echo $write['wr_max'] ?>" id="wr_max" class="frm_input only-number" placeholder="숫자만입력하세요"></td>
        </tr>
        <tr>
            <th scope="row"><label for="wr_roomprice">기준인원 초과시 추가요금</label></th>
            <td>
                <table>
                    <thead>
                        
                        <th scope="row"><span class="add_price">성인추가요금</span></th>
                        <th scope="row"><span class="add_price">소인추가요금</span></th>
                        <th scope="row"><span class="add_price">유아추가요금</span></th>
                    </thead>
                    <tr>
                        
                        <td><input type="text" value="<?php echo $write['wr_11']?>" name="wr_11" id="wr_11" class="frm_input only-number"></td>
                        <td><input type="text" value="<?php echo $write['wr_12']?>" name="wr_12" id="wr_12" class="frm_input only-number"></td>
                        <td><input type="text" value="<?php echo $write['wr_13']?>" name="wr_13" id="wr_13" class="frm_input only-number"></td>
                    </tr>
                   
                </table>
            </td>
        </tr>
        <tr>
            <th>기간</th>
            <td>
                <table>
                    <?php
                    //기간설정 가져오기
                    $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'date/config'";
                    $result = sql_query($sql);
                    $i = 0;
                    while ($row = sql_fetch_array($result)) {
                        $date_config[$i]['date_name'] = preg_replace("/_/", " ", $row['mta_db_id']);
                        $date_config[$i]['start_date'] = $row['mta_key'];
                        $date_config[$i]['end_date'] = $row['mta_value'];
                        $i++;
                    }


                    for ($i=0; $i < count($date_config); $i++) { ?>

                        <tr>
                            <th scope="row"><label for="date_config"><?php echo $date_config[$i]['date_name'];?></label></th>
                            <td><?php echo $date_config[$i]['start_date'];?> ~ <?php echo $date_config[$i]['end_date'];?></td>
                        </tr>
                    
                    <?php }?>
                </table>
            </td>
        </tr>
        

        
        <tr>
            <th scope="row"><label for="wr_roomprice">요금</label></th>
            <td>
                <table>
                    <thead>
                        <th  style="width: 50px;"></th>
                        <th scope="row" class="add_price">평일(일~목)</th>
                        
                        <?if ($board['bo_7_subj']) {
                            echo '<th scope="row" class="add_price">주말(금)</th>';
                            echo '<th scope="row" class="add_price">주말(토)</th>';
                            if ($board['bo_7_subj'] == "2") {
                                echo '<th scope="row" class="add_price">평일(일)</th>';
                            }
                        }else{
                            echo '<th scope="row" class="add_price">주말</th>';
                        }?>
                        
                        
                    </thead>
                    <tr>
                        
                        <th scope="row" ><label for="date_config">비수기</label></th>
                        <td><input type="hidden" name="date_name" value="비수기">
                            <input type="text" value="<?php echo $write['wr_weekday비수기']?>" name="wr_weekday비수기" class="frm_input only-number" style="width: 100%"></td>
                        <td><input type="text" value="<?php echo $write['wr_weekend비수기']?>" name="wr_weekend비수기" class="frm_input only-number" style="width: 100%"></td>
                        <?php if ($board['bo_7_subj']): ?>
                            <td><input type="text" value="<?php echo $write['wr_weekend2비수기']?>" name="wr_weekend2비수기" class="frm_input only-number" style="width: 100%"></td>
                        <?php endif ?>
                        <?php if ($board['bo_7_subj']=="2"): ?>
                            <td><input type="text" value="<?php echo $write['wr_weekend3비수기']?>" name="wr_weekend3비수기" class="frm_input only-number" style="width: 100%"></td>
                        <?php endif ?>
                    </tr>
                    <?php
                    for ($i=0; $i < count($date_config); $i++) { 
                        $day_name = "wr_weekday".$date_config[$i]['date_name'];
                        $end_name = "wr_weekend".$date_config[$i]['date_name'];
                        $end2_name = "wr_weekend2".$date_config[$i]['date_name'];
                        $end3_name = "wr_weekend3".$date_config[$i]['date_name'];
                        $date_repl_name = preg_replace("/_/", " ", $date_config[$i]['date_name']);

                    ?>
             
                        <tr>
                            <th scope="row"><label for="date_config"><?php echo $date_repl_name?></label></th>
                            <td>
                                <input type="hidden" name="date_name" value="<?php echo $date_config[$i]['date_name'];?>">
                                <input type="text" value="<?php echo $write[$day_name]?>" name="wr_weekday<?=$date_config[$i]['date_name'];?>" class="frm_input only-number" style="width: 100%">
                            </td>
                            <td>
                                <input type="text" value="<?php echo $write[$end_name]?>" name="wr_weekend<?=$date_config[$i]['date_name'];?>" class="frm_input only-number" style="width: 100%">
                            </td>
                            <?php if ($board['bo_7_subj']): ?>
                                <td>
                                    <input type="text" value="<?php echo $write[$end2_name]?>" name="wr_weekend2<?=$date_config[$i]['date_name'];?>" class="frm_input only-number" style="width: 100%">
                                </td>
                            <?php endif ?>
                            <?php if ($board['bo_7_subj'] == "2"): ?>
                                <td>
                                    <input type="text" value="<?php echo $write[$end3_name]?>" name="wr_weekend3<?=$date_config[$i]['date_name'];?>" class="frm_input only-number" style="width: 100%">
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php }?>
                    </tr>
                </table>
            </td>
        </tr>
       
        <tr>
            <th scope="row"><label for="wr_roomsale">연박할인 여부 <input type="checkbox" <?php if ($write['wr_roomsale']) {echo "checked";}?> id="wr_roomsale" name="wr_roomsale" value="1"></label></th>
            <td id = "sale_maker">
                
                <?if ($write['wr_roomsale']) {?>
                    
                    2박 예약시 <input type='text' name='wr_roomsale1' value='<?php echo $write['wr_roomsale1'] ?>' id='wr_roomsale1' class='frm_input only-number' style="width: 94px;"> 원 할인<br>
                    3박 예약시 <input type='text' name='wr_roomsale2' value='<?php echo $write['wr_roomsale2'] ?>' id='wr_roomsale2' class='frm_input only-number' style="width: 94px;"> 원 할인<br>
                    4박이상 예약시 <input type='text' name='wr_roomsale3' value='<?php echo $write['wr_roomsale3'] ?>' id='wr_roomsale' class='frm_input only-number' style="width: 94px;"> 원 할인
                <?}else{
                     echo "연박할인 사용시 체크해 주세요";
                }?>
                    
                
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="wr_add_option">옵션 추가</label>  <input type="button" onclick="addOption()" value="  +  "></th>
            <td id = wr_add_option>
                <table id="add_option_append">
                <?php 

                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/".$bo_table."' and mta_db_id  = '".$wr_id."' AND mta_key LIKE '%wr_option_%'";
                $result = sql_query($sql);
                $option_array = array();
                $i = 0;
                $j = 0;
                while ($row = sql_fetch_array($result)) {
                    
                    if ($i%2 ==0) {
                        $option_array[$j]['op_name'] = $row['mta_value'];
                        
                    }else{

                        $option_array[$j]['op_price'] = $row['mta_value'];
                        $option_array[$j]['op_key'] = $row['mta_key'];
                        $j++;
                    }
                    $i++;
                }
                
                for ($i=0; $i < count($option_array); $i++) { ?>
                    <tr class="col_option">
                        <td style="width: 10%;padding: 0;">옵션명</td>
                        <td><input type='text' style="width: 100%" class='frm_input ops_class_name' name="wr_option_name<?=$i?>" value="<?= $write['wr_option_name'.$i]?>"></td>
                        <td style="width: 10%;padding: 0;">가격</td>
                        <td><input type='text' style="width: 87px;" class='frm_input ops_class_price only-number' name="wr_option_price<?=$i?>" value="<?= $write['wr_option_price'.$i]?>" ><input type="button" style="width: 10%;" value="X" name='remove_op'></td>
                        
                    </tr>
                     <!-- 옵션명 <input type='text' style="width: 30%" class='frm_input' name="wr_option_name<?=$i?>" value="<?= $write['wr_option_name'.$i]?>"> 가격 <input type='text' style="width: 30%" class='frm_input' name="wr_option_price<?=$i?>" value="<?= $write['wr_option_price'.$i]?>" ><br> -->
                <?php }
                $op_count = $i;
                ?>

                </table>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_content">객실소개<strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <!-- <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label></th>
            <td><input type="url" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input wr_link"></td>
        </tr>
        <?php } ?> -->
        
        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <tr>
            <th scope="row">객실사진<?php echo $i+1 ?></th>
            <td>
                <div class="file_box">
                    <input type="text" class="file_name frm_input">
                    <a href="javascript:" class="file_btn">파일첨부</a>
                    <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                </div>
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')'; ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <script>
            $('input[type=file]').change(function(){
                $(this).siblings('.file_name').val($(this).val());
            });
        </script>
        <?php } ?>

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

    </div>

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
    </div>
    </form>
</section>
<!-- 시즌관리 -->
<div class="modal fade" id="import" role="dialog">
    <div class="modal-dialog" style="z-index: 9999;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5><i class="fa fa-list" aria-hidden="true"></i> 객실 불러오기</h5>
            </div>
            <div class="modal-body tbl_head01 tbl_wrap" style="max-height: 500px;overflow: auto;">
               
                <table>
                    <thead>
                        <tr>
                            <th width="20%">번호</th>
                            <th width="55%">객실명</th>
                            <th width="25%">관리</th>
                        </tr>
                    </thead>
                    <tbody class="gd_tbody2">
                      <?
                      $sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table}";
                      $result = sql_query($sql);
                      $i = 1;
                      while ($row = sql_fetch_array($result)) {
                          echo "<tr>";
                          echo "<td style='text-align: center;'>".$i."</td>";
                          echo "<td style='text-align: center;'>".$row['wr_subject']."</td>";
                          echo "<td style='text-align: center;'><input type='button' data-dismiss='modal' value='선택' name='booking_choise' id='".$row['wr_id']."' class='btn btn-primary btn-xs' style='width: 100px;'></td>";
                          echo "</tr>";
                          $i++;
                      }
                      
                      ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"> 닫기</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() { 
    $(document).on('keyup', '.only-number', function(event) {
        $(this).val($(this).val().replace(/[^0-9]/g,""));
    });
    
    $('#import_booking').click(function() {
        $('#import').modal();
    });
    $('[name=booking_choise]').click(function() {
        var id = $(this).attr('id');

        $.ajax( {
                url: "<?=$board_skin_url?>/ajax/ajax_import_room.php",
                type: "POST",
                data: {
                    "bo_table" : "<?=$bo_table?>",
                    "id" : id
                }, 
                dataType: "json",
                async: false,
                cache: false,
                beforeSend : function(){
                    count = 0;
                    $('.col_option').remove();
                },
                success: function( data, textStatus ) {
                    
                    // console.log(data);
                    //옵션 가져오기
                    for (var i = 0; i < data.length; i++) {
                        addOption();
                    }
                    //연박할인 가져오기
                    if (data.wr_roomsale) {
                        $('#wr_roomsale').prop("checked", true);
                        $('#wr_roomsale').change();
                    }
                    //내용 채우는 부분
                    for( var key in data ) {
                        $('[name='+key+']').val(data[key]);
                    }

                    
                
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
        } );
        
    });

    $("#wr_roomsale").change(function(){
        if ($("#wr_roomsale").is(":checked")) {

            document.getElementById("sale_maker").innerHTML = "2박 예약시 <input type='text' name='wr_roomsale1' value='<?php echo $write['wr_roomsale1'] ?>' id='wr_roomsale1' class='frm_input only-number' style='width: 94px;'> 원 할인<br>3박 예약시 <input type='text' name='wr_roomsale2' value='<?php echo $write['wr_roomsale2'] ?>' id='wr_roomsale2' class='frm_input only-number' style='width: 94px;'> 원 할인<br>4박이상 예약시 <input type='text' name='wr_roomsale3' value='<?php echo $write['wr_roomsale3'] ?>' id='wr_roomsale' class='frm_input only-number' style='width: 94px;'> 원 할인";
        }else{
            document.getElementById("sale_maker").innerHTML = "<input type='hidden' name='wr_roomsale' value='' id='wr_roomsale' class='frm_input'>연박할인 사용시 체크해 주세요";
        }
    })
});


    count= <?php echo $op_count?>;
    function addOption(){
       
        // '<td><input type="text" style="width: 100%" class='frm_input' name="wr_option_name<?=$i?>" value="<?= $write['wr_option_name'.$i]?>"></td>
        // <td style="width: 10%;padding: 0;">가격</td>
        // <td><input type='text' style="width: 90%" class='frm_input' name="wr_option_price<?=$i?>" value="<?= $write['wr_option_price'.$i]?>" ><input type="button" style="width: 10%;" value="X"></td>
        // </tr>'

        var txt = "<tr class='col_option'><td style='width: 10%;padding: 0;'>옵션명</td><td><input type='text' class='frm_input' name='wr_option_name"+count+"' style='width: 100%'></td><td style='width: 10%;padding: 0;'>가격</td><td><input type='text' class='frm_input only-number' name='wr_option_price"+count+"' style='width: 87px;'><input type='button' style='width: 10%;' value='X' name='remove_op'></td></tr>";
        // var txt = "옵션명 <input type='text' class='frm_input' name='wr_option_name"+count+"' style='width: 30%'> 가격 <input type='text' class='frm_input' name='wr_option_price"+count+"' style='width: 30%'><br>";

        $("#add_option_append").append(txt);
        count = count+1;
    }
$(document).on('click', '[name="remove_op"]', function() {
    $(this).closest('tr').remove();
    count -= 1;
    $('.col_option').each(function(index, el) {
        $(this).children('td').children('.ops_class_name').attr('name', 'wr_option_name'+index);
        $(this).children('td').children('.ops_class_price').attr('name', 'wr_option_price'+index);
    });
});

$("input[id^='wr_hot']").each(function(){
    var _this = this.id;

    $('#'+_this).datepicker({

        changeMonth: true, 
        changeYear: true, 
        dateFormat: "yy-mm-dd", 
        showButtonPanel: true, 
        yearRange: "c-99:c+99", 
        buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
        buttonImageOnly: true, showOn: 'both'
        
    });
});
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
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

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

    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>

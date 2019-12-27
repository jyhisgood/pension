<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once $board_skin_path . "/lib/thumbnail.lib.php";
include_once($board_skin_path.'/classes/Holidays.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style type="text/css">

#bo_v_cons a {
    color: #f5f5f5;
}
.add_price{
    font-size: 12px;
}
a.btn_b02s {
    display: inline-block;
    margin: 0 0 30px;
    padding: 8px 7px 7px;
    border: 1px solid #3b3c3f;
    background: #4b545e;
    color: #fff;
    text-decoration: none;
    vertical-align: middle;
}
</style>
<script src="<?php echo $board_skin_url; ?>/lib/pgwslideshow.min.js"></script>
<link rel="stylesheet" href="<?php echo $board_skin_url?>/lib/pgwslideshow_light.min.css">
<link rel="stylesheet" href="<?php echo $board_skin_url?>/lib/pgwslideshow.min.css">

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <?php
    if ($view['link']) {
    ?>
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01 pre_bt" style="width: 72px;">이전객실</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01 next_bt" style="width: 72px;">다음객실</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_admin">객실수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_admin" onclick="del(this.href); return false;">객실삭제</a></li><?php } ?>
            <!-- <?php if ($copy_href) { ?><li><a href="<//?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?> -->
            <!-- <?php if ($move_href) { ?><li><a href="<//?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?> -->
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href."&route=reserve_set" ?>" class="btn_b01">목록</a></li>
            <!-- <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } ?> -->
            <?php if ($member['mb_level'] >=8): ?>
                <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">객실등록</a></li><?php } ?>    
                <?php endif ?>
            
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <h2 class="reservAccountTitle" style="text-align:center;padding-bottom: 30px;">
        <span class="highlight"><i class="fab fa-envira"></i></span> 
        <span class="highlight1">객실 정보</span> 
        
    </h2>
        <?php
        
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"slideshow\" style='max-width:100%;'>
            <ul class='pgwSlideshow'>
            \n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail2($view['file'][$i]['view']);
                }
            }

            echo "</ul></div>\n";
        }
         ?>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>
            <div class="row" id="bo_v_con">
                <div class="col-sm-12 wrap">
                    
                    <table>
                        <tbody>
                            <tr>
                                <td>객실명</td>
                                <td><?php echo $view['subject']; ?></td>
                            </tr>
                            <tr>
                                <td>평 수</td>
                                <td>
                                    <?php echo $view['wr_area']?>평
                                </td>
                            </tr>
                            <tr>
                                <td>입실/퇴실 시간</td>
                                <td>
                                    입실 : <?php echo $view['wr_roomstdate']; ?> / 퇴실 : <?php echo $view['wr_roomendate']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>기준인원 / 최대인원</td>
                                <td><?php echo $view['wr_min']."명 / ".$view['wr_max']."명";?></td>
                            </tr>
                            <?php 
                            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'date/config'";
                            $result = sql_query($sql);
                            $i = 0;
                            while ($row = sql_fetch_array($result)) {
                                $date_config[$i]['date_name'] = $row['mta_db_id'];
                                $date_config[$i]['start_date'] = strtotime($row['mta_key']);
                                $date_config[$i]['end_date'] = strtotime($row['mta_value']);
                                $i++;
                            }
                            $selected_date = strtotime($_GET['reservation_date']);
                            $chk_weekend = date("w", $selected_date);
                            for ($i=0; $i < count($date_config); $i++) { 
                                if ($date_config[$i]['start_date'] <= $selected_date && $date_config[$i]['end_date'] >= $selected_date) {
                                    $name_value = $date_config[$i]['date_name'];
                                }
                            }
                            // echo $view['wr_weekday성수기'];
                            if ($name_value == "") {
                                $name_value = "비수기";
                            }
                            if ($chk_weekend==5 || $chk_weekend==6) {
                                if ($chk_weekend == 6 && $board['bo_7_subj'] == 1) {
                                    $daily = "wr_weekend2".$name_value;    
                                    ;
                                }elseif ($chk_weekend==5 && $board['bo_8_subj'] == 1) {
                                    $daily = "wr_weekday".$name_value;
                                }else{
                                    $daily = "wr_weekend".$name_value;    
                                }
                                
                                
                            }else{
                                $daily = "wr_weekday".$name_value;
                            }

                            if ($_GET['reservation_date']) {
                                
                                //환경설정 주말요금 받기 여부
                                if ($board['bo_5_subj']=="1") {
                                    
                                    $calendar = new Calendar();

                                    $is_holiday = $calendar->getHolidayWeekend($reservation_date);

                                                                
                                    if ($is_holiday) {
                                        $value_2 = "weekend";
                                        if($board['bo_7_subj']=="1"){
                                            $value_2 = "weekend2";
                                        }
                                        $daily = str_replace('weekday', $value_2, $daily);
                                    }
                                }
                                
                            }
                            if ($view[$daily] == "") {
                                $daily = str_replace($name_value, '비수기', $daily);
                            }
                            $name_value = preg_replace("/_/", " ", $name_value);
                            ?>
                            <tr>
                                <td>객실요금</td>
                                <td><?php echo number_format($view[$daily])?>원 (<?=$name_value?>적용 1박2일기준)</td>
                            </tr>
                            
                            <tr>
                                <td>기준인원 초과시 추가요금</td>
                                <td>
                                    <table>
                                        <thead>
                                            <th style="width: 33%;padding-top: 4px;padding-bottom: 4px;"><span class="add_price">성인추가요금</span></th>
                                            <th style="width: 33%;padding-top: 4px;padding-bottom: 4px;"><span class="add_price">소인추가요금</span></th>
                                            <th style="width: 33%;padding-top: 4px;padding-bottom: 4px;"><span class="add_price">유아추가요금</span></th>
                                        </thead>
                                        <tbody>
                                            <td><?php echo number_format($view['wr_11'])?>원</td>
                                            <td><?php echo number_format($view['wr_12'])?>원</td>
                                            <td><?php echo number_format($view['wr_13'])?>원</td>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?
                            $sql = "SELECT * FROM {$g5['board_table']} WHERE bo_table = '{$board['bo_1']}'";
                            $board_fetch = sql_fetch($sql);
                            ?>
                            <?php if ($board_fetch['bo_1_subj'] != ''): ?>
                            <tr>
                                
                                <td>애완동물 추가요금</td>
                                <td>1마리당 1박시 <?=number_format($board_fetch['bo_1_subj'])?>원</td>
                            </tr>
                            <?php endif ?>
                            <!-- <tr>
                                <td>시즌</td>
                                <td>
                                    <table>
                                        <?php
                                        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'date/config'";
                                        $result = sql_query($sql);
                                        $i = 0;
                                        while ($row = sql_fetch_array($result)) {
                                            $date_config[$i]['date_name'] = $row['mta_db_id'];
                                            $date_config[$i]['start_date'] = $row['mta_key'];
                                            $date_config[$i]['end_date'] = $row['mta_value'];
                                            $i++;
                                        }
                                        for ($i=0; $i < count($date_config); $i++) { 
                                        ?>

                                        <tr>
                                            <td><?php echo $date_config[$i]['date_name']?></td>
                                            <td><?php echo $date_config[$i]['start_date']?> ~ 
                                                <?php echo $date_config[$i]['end_date']?></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </td>
                            </tr> -->
                            
                            
                            
                            <!-- <tr>
                                <td>요금</td>
                                <td>
                                    <table>
                                        <thead>
                                            <th></th>
                                            <th>평일(일~목)</th>
                                            <th>주말(금,토)</th>
                                            
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo "비수기"?></td>
                                                <td><?php echo $view['wr_weekday비수기']?>원</td>
                                                <td><?php echo $view['wr_weekend비수기']?>원</td>
                                                
                                            </tr> 
                                            <?php for ($i=0; $i < count($date_config); $i++) { 
                                                $day_name = "wr_weekday".$date_config[$i]['date_name'];
                                                $end_name = "wr_weekend".$date_config[$i]['date_name'];
                                            ?>
                                            <tr>
                                                <td><?php echo $date_config[$i]['date_name']?></td>
                                                <td><?php echo $view[$day_name]?>원</td>
                                                <td><?php echo $view[$end_name]?>원</td>
                                            </tr>    
                                            <?php }?>
                                        </tbody>
                                    </table>                        
                                </td>
                            </tr>  -->
                            <?php if ($_GET['reservation_date']) {?>
                                <tr>
                                    <td>선택하신 날짜</td>
                                    <td><?php echo $_GET['reservation_date'];?></td>
                                </tr>
                            <?php }?>
                            <?php if ($view['wr_option_name0']): ?>
                                <tr>
                                <td>옵션 목록</td>
                                <td>
                                    <?php for ($i=0; $i < 10; $i++) { 
                                        if (!$view["wr_option_name$i"]) {
                                            break;
                                        }
                                        echo "이름 : ".$view["wr_option_name$i"]." 가격 : ".number_format($view["wr_option_price$i"])."원<br>";
                                    }?>
                                </td>
                            </tr>
                            <?php endif ?>
                            <?php if ($view['wr_roomsale'] == 1): ?>
                                <tr>
                                    <td>연박시 할인혜택</td>
                                    <td>
                                        2박 예약시 <?php echo number_format($view['wr_roomsale1'])?>원 할인<br>
                                        3박 예약시 <?php echo number_format($view['wr_roomsale2'])?>원 할인<br>
                                        4박이상 예약시 <?php echo number_format($view['wr_roomsale3'])?>원 할인
                                    </td>
                                </tr>    
                            <?php endif ?>
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>


    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
           <!--  <div class="order_box" style="float:right;">
            
                <a href="<?php echo G5_URL;?>/bbs/write.php?bo_table=<?=$board['bo_1']?>&bor_table=<?php echo $bo_table ?>&id=<?php echo $view['wr_id'];?>&reservation_date=<?php echo $_GET['reservation_date']?>" class="btn_b02" id="order_button" target="_self">예약하기</a>
            
            
            </div>  -->
        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
                       
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn_b01">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good">이 글을 추천하셨습니다</b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn_b01">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <?php
        include(G5_SNS_PATH."/view.sns.skin.php");
        ?>
    </section>

    <?php
    // 코멘트 입출력
    //include_once(G5_BBS_PATH.'/view_comment.php');
     ?>

    <div id="bo_v_bot">
        <!-- 링크 버튼 -->
        <?php echo $link_buttons ?>
    </div>

</article>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<!-- 게시글 보기 끝 -->

<script>
$(function() {


    $(document).ready(function() {
        $('.pgwSlideshow').pgwSlideshow({
            transitionEffect : "<?php echo $transitionEffect?>",
            autoSlide : "<?php echo $autoSlide?>",
            //maxHeight : "<?php echo maxHeight?>"



        });
    });


    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
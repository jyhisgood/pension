<?

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;
if ($is_checkbox) $colspan++;
?>

<div class="bo_fx">

    <div id="bo_list_total">
        <?php echo $total_count ?>
        <span>Total <?php echo number_format($total_count) ?>건</span>
        <?php echo $page ?> 페이지
    </div>
    
    <fieldset id="bo_sch">
        <div style="margin-bottom: 8px;">
            <form name="excel_download" method="POST" action="<?=$board_skin_url?>/reserve/excelDownload.php">
                <input type="hidden" name="bo_table" value="<?=$bo_table?>">
                <input type="hidden" name="bo_1" value="<?=$board['bo_1']?>">
                <input type="hidden" name="date_area" value="wr_datetime">
                 <!-- <select name="date_area">
                    <option value="wr_9">입실날짜</option>
                    <option value="wr_10">퇴실날짜</option>
                    <option value="wr_datetime">예약날짜</option>
                </select> -->
                <select name="excel_sort" id="excel_sort">
                    <option value="wr_2">예약자순</option>
                    <option value="wr_datetime">예약날짜순</option>
                    <option value="wr_9">입실날짜순</option>
                    <option value="wr_5">객실명순</option>
                    <option value="wr_6">상태순</option>
                </select>
                <input name = "startdt" class="frm_input dtpicker" readonly="readonly" style="width: 87px;"> ~ 
                <input name = "enddt" class="frm_input dtpicker" readonly="readonly" style="width: 87px;">
                
                <input type="submit" value="엑셀 다운로드" class="btn btn-default" style="width: auto;" id="">
            </form>
        </div>
        <legend>게시물 검색</legend>
        <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sop" value="and">
        <label for="sfl" class="sound_only">검색대상</label>
        <select name="sfl">
            <!-- <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option> -->
            <option value="wr_6"<?php echo get_selected($sfl, 'wr_6'); ?>>상태</option>
            <option value="wr_9"<?php echo get_selected($sfl, 'wr_9'); ?>>입실날짜</option>
            <option value="wr_5"<?php echo get_selected($sfl, 'wr_5'); ?>>객실명</option>
            <!-- <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option> -->
            <!-- <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option> -->
            <!-- <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option> -->
            <!-- <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option> -->
            <option value="wr_2,1"<?php echo get_selected($sfl, 'wr_2,1'); ?>>예약자</option>
            <option value="wr_1,1"<?php echo get_selected($sfl, 'wr_1,1'); ?>>휴대폰번호</option>
            <!-- <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option> -->
        </select>
        <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required frm_input" size="15" maxlength="20">
        <input type="submit" value="검색" class="btn_submit">
        </form>
    </fieldset>
</div>



<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="sw" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <?php if ($is_checkbox) { ?>
        <th scope="col">
            <label for="chkall">현재 페이지 게시물 전체</label>
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
        </th>
        <?php } ?>

		<!-- <th scope="col" style="width:50px;">번호</th>
        <th scope="col" style="width:220px;">예약자/객실명</th>
        <th scope="col" style="width:100px;">예약금액</th>
		<th scope="col" style="width:100px;">상태</th>
		<th scope="col" style="width:73px;">입실날짜</a></th> -->
        <th scope="col" style="width: 50px;">번호</th>
        <th scope="col" style="width: 120px;">예약자명</th>
        <th scope="col" style="width: 150px;">객실명</th>
        <th scope="col" style="width: 150px;">입실날짜</th>
        <th scope="col" style="width: 110px;">예약금액</th>
        <th scope="col" style="width: 150px;">작성일</th>
        <th scope="col" style="width: 100px;">상태</th>
        
    </tr>
    </thead>
    <tbody>
		

    <?php
    for ($i=0; $i<count($list); $i++) {

    ?>
    <?php
    //booking,meta 테이블 $_get[id]로 합침

    //booking 테이블 호출
    $sql = "SELECT * FROM {$g5['write_prefix']}{$board['bo_1']} WHERE wr_id = '{$list[$i]['wr_3']}'";
    $booking_tb = sql_fetch($sql);

    //meta 테이블 호출
    $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$board['bo_1']}' AND mta_db_id = '{$list[$i]['wr_3']}'";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        $booking_tb[$row['mta_key']] = $row['mta_value'];
    }
    $tempWr_5 = explode("|", $list[$i]['wr_5']);
    $tempWr_9 = explode("|", $list[$i]['wr_9']);
    $tempWr_8 = explode("|", $list[$i]['wr_8']);
    $totalWr_8 = "";
    for ($q=0; $q < count($tempWr_8); $q++) { 
        $tempWr_8[$q] = str_replace('원', '', $tempWr_8[$q]);
        $tempWr_8[$q] = str_replace(',', '', $tempWr_8[$q]);

        $totalWr_8 += $tempWr_8[$q];
    }

    
    // print_r2();
    // echo "<br>";


    ?>
    
    <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
        <?php if ($is_checkbox) { ?>
        <td class="td_chk">
            <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
            <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
        </td><?php } ?>
		<td style="text-align: center;"><?echo $list[$i]['num']?></td>
        <td class="td_subject" style="<?=$align;?> ">
            <?php
            if ($is_category && $list[$i]['ca_name']) {
            ?>                
			<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
            <?php } ?>

            <a href="<?php echo $list[$i]['href'];?><?php if($_GET['resv_name']){echo '&resv_name='.$_GET['resv_name'];}?>">
			<?echo $list[$i]['icon_reply'];?>
                <?php echo $list[$i]['wr_2'] ?>님                     
				<?php
                // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                // if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                // if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                // if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                // if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                ?>
            </a>
            
            <td style="text-align: center;">
                <?if (count($tempWr_5) == "1") {
                    echo $tempWr_5[0];
                }else{
                    echo $tempWr_5[0]." 외 ".(count($tempWr_5)-1);
                }?>
            </td>
            <td class="td_date">
                <?if (count($tempWr_9) == "1") {
                    echo $tempWr_9[0];
                }else{
                    echo $tempWr_9[0]." 외 ".(count($tempWr_9)-1);
                }?>
            </td>
			<td style="text-align: center;"><?=number_format($totalWr_8)?>원</td>
            
            <td class="td_date"><?php echo $list[$i]['datetime'] ?></td>
			<td style="text-align: center;">
				<?php
                
                    if ($list[$i]['wr_6'] == "예약완료") {
                        echo "<font color='red' style='padding-right:10px;'>".$list[$i]['wr_6']."</font>";
                        if ($member['mb_level'] >= 8) {
                        echo '<input type="button" id="'.$list[$i]['wr_id'].'" class="btn btn-default btn-xs resBtn" style="width:80px;" name="status_update" value="예약대기">';
                        }
                    }else {
                        echo "<font color='gray' style='padding-right:10px;'>".$list[$i]['wr_6']."</font>";
                        if ($member['mb_level'] >= 8) {
                            echo '<input type="button" id="'.$list[$i]['wr_id'].'" class="btn btn-default btn-xs resBtn" style="width:80px;" name="status_update" value="예약완료">';
                        }
                    }
				
				?>
			</td>
        </td>
        
        
        
    </tr>
    <?php } ?>
    <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
    </tbody>
    </table>
</div>

<?php if ($list_href || $is_checkbox || $write_href) { ?>
<div class="bo_fx">
    <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b02">RSS</a></li><?php } ?>
            <?php if ($is_admin == 'super') { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
            <!-- <?php if ($write_href) { ?><li clss="write_btn"><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?> -->
        </ul>
     <?php } ?>
     
    <ul class="btn_bo_adm">
        <?php if ($list_href) { ?>
        <!-- <li><a href="<?php echo $list_href ?>" class="btn_b02"> 목록</a></li> -->
        <?php } ?>
        <?php if ($is_checkbox) { ?>
        <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
        <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
        <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>

</form>
<?php echo $write_pages; ?>
<script>
$('.dtpicker').datepicker({ 
                changeMonth: true, 
                changeYear: true, 
                dateFormat: "yy-mm-dd", 
                yearRange: "c-99:c+99", 
                prevText: '이전 달',
                nextText: '다음 달',
                monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                yearSuffix: '년',
                // buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
                // buttonImageOnly: true, showOn: 'both'
                });

$("input[name='status_update']").click(function(){
    $id = $(this).attr("id");
    $value = $(this).val();
    $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_change_status.php",
            type: "POST",
            data: {
                "status" : "update",
                "bo_table" : '<?=$bo_table?>',
                "id" : $id,
                "value" : $value
            },
            // dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                console.log(data);
                
                alert("수정되었습니다.");
                location.reload();
                // document.getElementById("total_price").innerHTML = data.price.total+"원";
            },
            error: function( xhr, textStatus, errorThrown ) {
                location.reload();
                // alert("수정되었습니다");
                // console.error( textStatus );
            }
    } );
})

</script>
<!-- 페이지 -->



<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {

    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->

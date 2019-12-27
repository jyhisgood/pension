<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

?>


<!-- 게시판 목록 시작 -->
<div id="bo_gall" style="clear:both;">
    
   

    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="cate_mo dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
        <?php //echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> 카테고리<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <?php echo $category_option ?>
        </ul>
    </nav>
    
    <nav id="bo_cate_pc" class="cate_pc">
        <!--<h2><?php //echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> </h2>-->
        <div id="bo_cate_pc_ul">
            <?php echo $category_option ?>
        </div>
    </nav>
    <?php } ?>

    <div class="bo_fx">
        

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <!-- <?php if ($rss_href = false) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?> -->
            <!-- <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn btn-primary">관리자</a></li><?php } ?> -->
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-primary">객실등록</a></li><?php } ?>

        </ul>
        <?php } ?>
    </div>

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <h2 class="sound_only">이미지 목록</h2>

   <?php if ($is_checkbox) { ?>
    <div id="gall_allchk">
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
        <label for="chkall"><span class="sound_only">현재 페이지</span> 전체 선택</label>
    </div>
    
    <script>
    $('#gall_allchk label[for=chkall]').bind('click',function(){
        if($(this).siblings('input[type=checkbox]').is(':checked')){
            $(this).removeClass("focus");
        }else{
            $(this).addClass("focus");
        }
    });
    </script>
    <?php } ?>
    
    <ul id="gall_ul">
        <?php for ($i=0; $i<count($list); $i++) {
        ?>
        <li class="gall_li <?php if ($wr_id == $list[$i]['wr_id']) { ?>gall_now<?php } ?>">
        
            <?php if ($is_checkbox) { ?>
            <span class="td_chk">
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                <label for="chk_wr_id_<?php echo $i ?>"><span class="sound_only"><?php echo $list[$i]['subject'] ?></span></label>
            </span>
            <?php } ?>
            
            <span class="sound_only">
                <?php
                if ($wr_id == $list[$i]['wr_id'])
                    echo "<span class=\"bo_current\">열람중</span>";
                else
                    echo $list[$i]['num'];
                ?>
            </span>
            
            <div class="gall_con">
                <div class="gall_ica" id="gall_img" style="overflow: hidden;">
                    <a href="<?php echo $list[$i]['href'] ?>">
                    <?php


                    // print_r($g5);
                    
                    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], true, true, 'center');
                    
                    //echo $thumb_no;
                    if($thumb['src']) {
                        //$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
                        $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_mobile_gallery_width'].'" height="'.$board['bo_mobile_gallery_height'].'" > ';
                    } else {

                        if ($list[$i]['link'][1] == "") {
                            $thumb_no = thumbnail('no_img.png', $board_skin_path.'/img', G5_DATA_PATH.'/no_img', $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], true, true, 'center');
                            $img_content = "<img src='".G5_DATA_URL."/no_img/".$thumb_no."'>";  
                        }else{
                            
                            // $play_thum_addr = @thumbnail('play.png', $board_skin_path.'/img', G5_DATA_PATH.'/no_img', $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], true, true, 'center');
                            // $img_content = "<img src='".G5_DATA_URL."/no_img/".$play_thum_addr."' style='position:relative;opacity: 0.8;'>";


                            // $thumb_youtube = thumbnail($list[$i]['wr_2'], $board_skin_path.'/youtube_thum/', G5_DATA_PATH.'/youtube_list', $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], true, true, "center","youtube");

                            
                            // $play_thum = "<img src='".G5_DATA_URL."/youtube_list/".$thumb_youtube."' alt='".$thumb['alt']."' style='position:absolute;'";
                            // echo $play_thum;
                            // echo $img_content;
                            $thumb_no = thumbnail('background.png', $board_skin_path.'/img', G5_DATA_PATH.'/background', $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], true, true, 'center');
                            $img_content = "<img src='".G5_DATA_URL."/background/".$thumb_no."'>";
                            
                            $youtube_key = substr($list[$i]['wr_link1'],-11,11);

                            $url = "http://img.youtube.com/vi/".$youtube_key."/mqdefault.jpg"; //외부이미지

                            
                            
                            $img_content .= '<img src="'.$url.'" alt="" width="'.$board['bo_mobile_gallery_width'].'" height="'.$board['bo_mobile_gallery_height'].'" style="height: auto;top: 12%;position: absolute;"> ';
                            $img_content .= "<img src='".$board_skin_url."/img/play.png' style='height: auto;top: 0%;position: absolute;'>";
                        }
                    }

                    echo $img_content;

                    ?>

                    </a>
                    
                    <?php if ($list[$i]['is_notice']) { //공지사항 ?>
                        <div class="notice_icon"><i class="fa fa-star" aria-hidden="true"></i></div>
                    <?php } ?>
                    
                    
                    <?php if ($list[$i]['icon_new'] || $list[$i]['icon_new'] || $list[$i]['icon_hot'] || $list[$i]['icon_secret'] || $list[$i]['comment_cnt']) { ?>
                        <div class="cont_icon">
                            <?php if ($list[$i]['icon_new']) { ?><span class="icon_new"><?php if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];?></span><?php }?>
                            <?php if ($list[$i]['icon_hot']) { ?><span><?php if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];?></span><?php }?>
                            <?php if ($list[$i]['icon_secret']) { ?><span><?php if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];?><span><?php }?>
                            <?//php 
                            //if ($list[$i]['comment_cnt']) { ?>
                                <span class="sound_only">댓글</span>
                                <?//php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span>
                            <?//php } ?>
                        </div>
                    <?php } ?>
                    
                    <?php
                    if ($is_category && $list[$i]['ca_name']) {?>
                    <div class="bo_cate_link_div">
                        <!--<a href="<?//php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?//php echo $list[$i]['ca_name'] ?></a>-->
                        <div class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></div>
                    </div>
                    <?php } ?>
                </div>
                
                <div class="gall_con_cont">
                    <div class="gall_text_href">
                        <!--echo $list[$i]['icon_reply']; 갤러리는 reply 를 사용 안 할 것 같습니다. - 지운아빠 2013-03-04-->
                        
                        <a href="<?php echo $list[$i]['href'] ?>" class="gall_subj">
                            <?php echo $list[$i]['subject'] ?>
                        </a>
                            
                        
                        <?php
                        //if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                        //if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
                        //if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                        //if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                        ?>
                        <!--<li><span class="gall_subject"><i class="fa fa-eye" aria-hidden="true"></i> </span><?//php echo $list[$i]['wr_hit'] ?></li>-->
                        <?php if ($is_good < 0) { ?><div><span class="gall_subject"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </span><strong><?php echo $list[$i]['wr_good'] ?></strong></div><?php } ?>
                        <?php if ($is_nogood = false) { ?><li><span class="gall_subject"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> </span><strong><?php echo $list[$i]['wr_nogood'] ?></strong></li><?php } ?>
                    </div>
                    <!-- <div class="gall_con_info">
                        <div><span class="gall_subject"><i class="fa fa-user" aria-hidden="true"></i> </span><?php echo $list[$i]['name'] ?></div>
                        <div class="con_date"><span class="gall_subject"><i class="fa fa-clock-o" aria-hidden="true"></i></span><?php echo $list[$i]['datetime'] ?></div>
                    </div> -->
                </div>
            </div>
        </li>
        <?php } ?>
        <?php if (count($list) == 0) { echo "<li class=\"empty_list\">게시물이 없습니다.</li>"; } ?>
    </ul>
    
    <?php if ($is_checkbox) { ?>
    <script>
    $('.td_chk label').bind('click',function(){
        if($(this).siblings('input[type=checkbox]').is(':checked')){
            $(this).removeClass("focus");
        }else{
            $(this).addClass("focus");
        }
    });
    </script>
    <?php } ?>
    
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx bo_fx_adm">
        <ul class="btn_bo_adm">
            <?php if ($is_checkbox) { ?>
            <li><input class="btn btn-danger" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <!-- <li><input class="btn btn-danger" type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
            <li><input class="btn btn-danger" type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li> -->
            <?php } ?>
        </ul>

        <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn btn-default"> 목록</a></li><?php } ?>
            <li><?php if ($write_href = false) { ?><a href="<?php echo $write_href ?>" class="btn btn-primary">글쓰기</a><?php } ?></li>
        </ul>
    </div>
    <?php } ?>
    <?php if ($member['mb_level'] >= 8): ?>
    <input class="btn btn-primary" type="button" name="selected_move" data-table="<?=$bo_table?>" data-value="prev" value="앞으로 이동">
    <input class="btn btn-primary" type="button" name="selected_move" data-table="<?=$bo_table?>" data-value="chan" value="순서변경">
    <input class="btn btn-primary" type="button" name="selected_move" data-table="<?=$bo_table?>" data-value="next" value="뒤로 이동">
    <input class="btn btn-primary" type="button" name="sorting_mode"  data-table="<?=$bo_table?>" id="sorting_mode" value="드래그">
    <?php endif ?>
    </form>
</div>



<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php 
$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=','&route=reserve_set');
echo $write_pages; 
?>

<fieldset id="bo_sch">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, "wr_subject", true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, "wr_content"); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, "wr_subject||wr_content"); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, "mb_id,1"); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, "mb_id,0"); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, "wr_name,1"); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, "wr_name,0"); ?>>글쓴이(코)</option>
    </select>
    <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required form-control" size="15" maxlength="20">
    <input type="submit" value="검색">
    </form>
</fieldset>
<script type="text/javascript" src="<?=$board_skin_url?>/lib/draggable_sorting/draggable.js"></script>

<?php if ($is_checkbox) { ?>
<script>
$('#bo_cate_pc_ul li').each(function(){
        $(this).attr('class','btn btn-default');
});

if($(window).width() <= 767){
    $('#bo_cate_pc').hide();
    $('#bo_cate').show();
}
else{
    $('#bo_cate_pc').show();
    $('#bo_cate').hide();
}

$(window).resize(function(){
    if($(window).width() <= 767){
        $('#bo_cate_pc').hide();
        $('#bo_cate').show();
    }
    else{
        $('#bo_cate_pc').show();
        $('#bo_cate').hide();
    }
});
function all_checked(sw) {
    $('.td_chk').each(function(){
        $(this).find('input').attr('checked',sw);
        if(sw){
            $(this).find('label').addClass('focus');
        }else{
            $(this).find('label').removeClass('focus');
        }
    });
    
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

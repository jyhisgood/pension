<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
    
?>

<!-- 게시판 목록 시작 -->
<div id="bo_list<?php if ($is_admin) echo "_admin"; ?>">

    <?php
    //권한체크
    if ($member['mb_level'] < 8) {

        if ($_POST || isset($_SESSION['checkingReservation'])) {
            include_once($board_skin_path . '/reserve/userList.php');    
        }else{
            include_once($board_skin_path . '/check_reserve/checking.php');    
        }
           
    }else{
        
        include_once($board_skin_path . '/reserve/adminList.php');
    }?>

</div>

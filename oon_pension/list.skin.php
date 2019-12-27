<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


//캘린더 메인화면
include_once($board_skin_path."/lib/Functions.php");
include_once($board_skin_path."/costomSettings.php");
include_once($board_skin_path."/classes/Rooms.php");

$rooms = new Rooms($bo_table);
$total_list = $rooms->getRoomList('wr_num');

?>
<div id="bo_list" class="fz_wrap">
<?

if ($_GET['route']=="reserve_set") {

	add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/admin.css">', 0);
    include_once($board_skin_path."/searching_reservation/adminReservationManaging.php");
    include_once($board_skin_path."/searching_reservation/adminRoomManaging.php");

}else{

	add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/pension.css">', 0);
	add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
    include_once($board_skin_path."/searching_reservation/calendar.php");

}

?>
</div>
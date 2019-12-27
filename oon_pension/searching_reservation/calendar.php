<div id="wrap_content">
	<div id="wrap_search_form">
		<div>
			<div class="date_info">체크인</div>
		</div>
		<div>
			<div class="date_data"><span id="start">선택하세요</span></div>
		</div>
		<div>
			<div class="date_info">체크아웃</div>
		</div>
		<div>
			<div class="date_data"><span id="end">선택하세요</span></div>
		</div>
		<div>
			<div class="srch_booking">
				<input type="button" class="search_booking" value="객실검색">
			</div>
		</div>
	</div>

	<!-- ======== 달력 생성 부분 ======= -->
	<table id="cal_tb"></table> 	

</div>
<div class="wrap_setting_btn_list">
	<ul class="setting_btn_list">
		<?if ($member['mb_level'] < 8) {?>
    		<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?=$board['bo_1']?>" id = "checkg" class="btn btn-default" >예약확인</a></li>
    	<?}else{?>
    		<li><input type="button" id="settingbtn" class="btn btn-default" value="환경설정"></li>
	        <li><input type="button" id="goodsbtn" class="btn btn-default" value="시즌설정"></li>
	        <li><input type="button" id="reserve-list" class="btn btn-default" value="예약목록"></li>
	        <li><input type="button" id="manage-room" class="btn btn-default" value="객실관리"></li>

    	<?}?>
    	<!-- <li><input type="button" onclick="$('#season-price').modal();" class="btn btn-default" value="시즌별가격"></li> -->
	</ul>
</div>
<!--  
</div>
</div>
 -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	
<div style="clear: both;"></div>

<?php 
include_once($board_skin_path."/searching_reservation/modal/mainSearchModal.php");
include_once($board_skin_path."/searching_reservation/modal/seasonSettingsModal.php");
include_once($board_skin_path."/searching_reservation/modal/allSettingsModal.php");
?>

<!-- 미완성 -->
<?php //include_once($board_skin_path."/searching_reservation/modal/checkPricesModal.php")?>




<?
// include_once($board_skin_path."/classes/Rooms.php");

// $abc = new Rooms($bo_table);

// print_r2($abc->isHoliday('2019-11-01','2019-12-31'));


?>


<script type="text/javascript" src="<?=$board_skin_url?>/js/calendar/mainCalendar.js"></script>
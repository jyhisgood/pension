<?php
include_once('./_common.php');
include_once("../classes/Rooms.php");



$rooms = new Rooms($_POST['bo_table']);
//																	 {{{{{{{{{{{{{{{{ 인원수 설정시 }}}}}}}}}}}}}}}}
$serchingDatas = $rooms->searchRooms($_POST['start'], $_POST['end'], $_POST['type'], $_POST['id'], $_POST['count']);



echo json_encode($serchingDatas);

?>
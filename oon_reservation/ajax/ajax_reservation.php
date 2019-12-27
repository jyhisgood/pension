<?php 
include_once('./_common.php');


$price['animals'] = 0;
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];


$id = $_POST['id'];
$options = $_POST['op_name'];
$count = $_POST['op_value'];
$sale = $_POST['sale'];
$old1 = $_POST['old1'];
$old2 = $_POST['old2'];
$old3 = $_POST['old3'];


$rooms = new Rooms($_POST['bo_table']);	
$season = $rooms->isHoliday($start_date, $end_date);

//퇴실시간 계산	
$price['out_time'] = date("Y-m-d", strtotime($end_date));

//금액계산
$calThisRoomPrice =  $rooms->getPrice($season,$id);

//옵션계산
$calOptionsPrice =  $rooms->getOptionPrice($options, $count, $id);

//추가인원계산
$calExtraPrice =  $rooms->getAddPrice($old1, $old2, $old3, $id) * count($season);
	
//연박계산	
$calDiscountPrice =  $rooms->getSalePrice($season, $sale, $id);

//애완동물 입장 가격 계산
if ($_POST['bo_1_subj'] != "") {
	$calPetExtraPrice = ($_POST['animals'] * $_POST['bo_1_subj']) * count($season);
	
}


//결제금액 계싼
$price['total']   = number_format($calOptionsPrice + $calThisRoomPrice - $calDiscountPrice + $calExtraPrice + $calPetExtraPrice);	
$price['reserve'] = number_format($calThisRoomPrice);
$price['option']  = number_format($calOptionsPrice);
$price['count']   = number_format($calExtraPrice);
$price['animals'] = number_format($calPetExtraPrice);
$price['sale']    = number_format($calDiscountPrice);

$st_obj = new DateTime($start_date); 
$en_obj = new DateTime($end_date);
$string = "";
$dt_diff = date_diff($st_obj, $en_obj);

for ($i=0; $i < $dt_diff->days; $i++) { 
	$string .= $st_obj->format('Y-m-d').";";
	$st_obj->modify('+1 day');
}

$string = substr($string, 0,-1);
$price['diff'] = $string;

echo json_encode($price);




?>
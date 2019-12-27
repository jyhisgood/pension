<?
include_once('../../../../../../common.php');



if ($_POST['excel_sort'] == "wr_2" || $_POST['excel_sort'] == "wr_6") {
    $_POST['excel_sort'] .= " asc";
}else{
    $_POST['excel_sort'] .= " desc";
}

$list_array       = array();
$admin_list_array = array();
$room_array       = array();





// $start = new DateTime($_POST['startdt']);
// $end = new DateTime($_POST['enddt']);
// $gap = date_diff($start, $end);
// // print_r2($gap);
// for ($i=0; $i <= $gap->days; $i++) { 
//     $dt = date_format($start,"Y-m-d");
    
//     $sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE  wr_is_comment = 0 AND wr_9 LIKE '%{$dt}%'";
//     echo $sql."<br>";

//     $start->modify("+1 day");


// }








$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE  wr_is_comment = 0 AND DATE({$_POST['date_area']}) BETWEEN '{$_POST['startdt']}' AND '{$_POST['enddt']}' order by {$_POST['excel_sort']}";

$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
 
	//메타테이블 포함
	$sql2 = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND mta_db_id = '{$row['wr_id']}'";
	$result2 = sql_query($sql2);
	while ($row2 = sql_fetch_array($result2)) {
		$row[$row2['mta_key']] = $row2['mta_value'];
	}

    //댓글 저장 (관리자메모)
    $sql = " select * from $write_table where wr_parent = '{$row['wr_id']}' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
    $result_comment = sql_query($sql);
    $comment_value = "";
    while ($comment = sql_fetch_array($result_comment)) {
        $comment_value .= $comment['wr_datetime'] .' : '. $comment['wr_content'].chr(10);
        
    }
    $row['wr_comment_content'] = $comment_value;


    $explArrWr_3 = explode("|", $row['wr_3']);
    $explArrWr_5 = explode("|", $row['wr_5']);
    $explArrWr_9 = explode("|", $row['wr_9']);
    $explArrWr_10 = explode("|", $row['wr_10']);
    $explArrWr_old1 = explode("|", $row['wr_old1']);
    $explArrWr_old2 = explode("|", $row['wr_old2']);
    $explArrWr_old3 = explode("|", $row['wr_old3']);
    $explArrWr_animals2 = explode("|", $row['wr_animals2']);
    $explArrWr_animals = explode("|", $row['wr_animals']);
    $optionArray = '';
    for ($l=0; $l < count($explArrWr_5); $l++) { 
        
        $sqlOption = "SELECT * FROM g5_pension_options WHERE op_wr_id = '{$row['wr_id']}' AND op_key = '{$explArrWr_3[$l]}' order by op_count";
        // echo $sqlOption."<br>";
        $resultOption = sql_query($sqlOption);
        while ($rowOptions = sql_fetch_array($resultOption)) {
            $optionArray .= $rowOptions['op_name']." : ".$rowOptions['op_count'].", ";
        }
        if ($l == 1) {
            $row['wr_2'] = '';
            
        }
        $row['wr_options'] = $optionArray;
        $row['wr_5'] = $explArrWr_5[$l];
        $row['wr_9'] = $explArrWr_9[$l];
        $row['wr_10'] = $explArrWr_10[$l];
        $row['wr_old1'] = $explArrWr_old1[$l];
        $row['wr_old2'] = $explArrWr_old2[$l];
        $row['wr_old3'] = $explArrWr_old3[$l];
        $row['wr_animals2'] = $explArrWr_animals2[$l];
        $row['wr_animals'] = $explArrWr_animals[$l];
        $list_array[] = $row;
    }

	//옵션 포함
	// $sql13 = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_1']} WHERE wr_id = '{$row['wr_3']}'";
	// $booking_tb = sql_fetch($sql13);
	
	// $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$_POST['bo_1']}' AND mta_db_id = '{$row['wr_3']}'";
	// $result3 = sql_query($sql);
	// while ($row3 = sql_fetch_array($result3)) {

	//     $booking_tb[$row3['mta_key']] = $row3['mta_value'];
	// }

	// $op_name = array();
	// foreach ($booking_tb as $key => $value) {
	//     if (strpos($key, "wr_option_name") !== false) {
	//         $op_name[] = $key;
	//     }
	// }
	
	// $option_info = "";
	// for ($i=0; $i < count($op_name); $i++) { 
		
	//     if ($row['wr_option_price'.$i]!=0) {

	//         $option_info .= $booking_tb[$op_name[$i]]." : ".$row['wr_option_price'.$i]."개,";
	         
	//     }   
	    
	// }


    // $op_sql = "SELECT * FROM g5_pension_options WHERE op_wr_id = '{}'";


	if ($option_info == "") $option_info = "없음"; 

	$row['wr_options'] = $option_info; 
	    
	
}


// exit;


$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_1']}";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $room_array[$row['wr_id']] = $row['wr_subject'];
}


if ($_POST['date_area'] == "wr_datetime") {
    $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'reserved' AND DATE(mta_reg_dt) BETWEEN '{$_POST['startdt']}' AND '{$_POST['enddt']}' order by mta_key desc";
}else{
    $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'reserved' AND DATE(mta_key) BETWEEN '{$_POST['startdt']}' AND '{$_POST['enddt']}' order by mta_key desc";
}


$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $admin_list_array[] = $row;
}

// $room_array[$row['mta_db_id']]
include_once(G5_LIB_PATH.'/PHPExcel.php');

/* PHPExcel.php 파일의 경로를 정확하게 지정해준다. */
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
// Excel 문서 속성을 지정해주는 부분이다. 적당히 수정하면 된다.
$objPHPExcel->getProperties()->setCreator($config['cf_title'])
                             ->setTitle(date('Y-m-d')." 예약리스트")
                             ->setSubject(date('Y-m-d')." 예약리스트");
                             
// Add some data
// Excel 파일의 각 셀의 타이틀을 정해준다.

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1", "예금주명")
            ->setCellValue("B1", "객실명")
            ->setCellValue("C1", "휴대폰번호")
            ->setCellValue("D1", "이메일")
            ->setCellValue("E1", "입실날짜")
            ->setCellValue("F1", "퇴실날짜")
            ->setCellValue("G1", "접수날짜")
            ->setCellValue("H1", "성인")
            ->setCellValue("I1", "소인")
            ->setCellValue("J1", "유아")
            ->setCellValue("K1", "입실예상시간")
            ->setCellValue("L1", "차량번호")
            ->setCellValue("M1", "애완동물수")
            ->setCellValue("N1", "애완동물요금")
            ->setCellValue("O1", "옵션")
            ->setCellValue("P1", "총요금")
            ->setCellValue("Q1", "상태")
            ->setCellValue("R1", "관리자메모");
// for 문을 이용해 DB에서 가져온 데이터를 순차적으로 입력한다.
// 변수 i의 값은 2부터 시작하도록 해야한다.

for ($i=2; $i < count($list_array)+2; $i++)
{   
    // Add some data
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", $list_array[$i-2]['wr_2'])
                ->setCellValue("B$i", $list_array[$i-2]['wr_5'])
                ->setCellValue("C$i", $list_array[$i-2]['wr_1'])
                ->setCellValue("D$i", $list_array[$i-2]['wr_mail'])
                ->setCellValue("E$i", $list_array[$i-2]['wr_9'])
                ->setCellValue("F$i", $list_array[$i-2]['wr_10'])
                ->setCellValue("G$i", $list_array[$i-2]['wr_datetime'])
                ->setCellValue("H$i", $list_array[$i-2]['wr_old1']."명")
                ->setCellValue("I$i", $list_array[$i-2]['wr_old2']."명")
                ->setCellValue("J$i", $list_array[$i-2]['wr_old3']."명")
                ->setCellValue("K$i", $list_array[$i-2]['wr_intime'])
                ->setCellValue("L$i", $list_array[$i-2]['wr_parking'])
                ->setCellValue("M$i", $list_array[$i-2]['wr_animals2'])
                ->setCellValue("N$i", $list_array[$i-2]['wr_animals'])
                ->setCellValue("O$i", $list_array[$i-2]['wr_options'])
                ->setCellValue("P$i", $list_array[$i-2]['wr_8'])
                ->setCellValue("Q$i", $list_array[$i-2]['wr_6'])
                ->setCellValue("R$i", $list_array[$i-2]['wr_comment_content']);

    $objPHPExcel->getActiveSheet()->getStyle("R$i")->getAlignment()->setWrapText(true);
    // $objPHPExcel->getActiveSheet()->getRowDimension($i)->setAutoSize(true);
}
$i = $i + 2;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", "관리자 예약")
            ->setCellValue("B$i", "객실명")
            ->setCellValue("C$i", "입실날짜")
            ->setCellValue("D$i", "상태")
            ->setCellValue("E$i", "작성일");

for ($j=0; $j < count($admin_list_array); $j++) { 
    $i++;
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", "관리자")
                ->setCellValue("B$i", $room_array[$admin_list_array[$j]['mta_db_id']])
                ->setCellValue("C$i", $admin_list_array[$j]['mta_key'])
                ->setCellValue("D$i", $admin_list_array[$j]['mta_value'])
                ->setCellValue("E$i", $admin_list_array[$j]['mta_reg_dt']);
                
}

$objPHPExcel -> getActiveSheet() -> getColumnDimension('Q') -> setAutoSize(true);
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle(date('Y-m-d')." 예약리스트");
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
$filename = iconv("UTF-8", "EUC-KR", date('Y-m-d')." 예약리스트");
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
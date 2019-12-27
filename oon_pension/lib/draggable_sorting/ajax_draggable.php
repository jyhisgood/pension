<?php
include_once("./_common.php");


/***********************************게시글 순서 바꾸기************************************/

$basic_list    = array(); // 전체 게시물
$num_list      = array(); // wr_num 담은 배열
$temp          = "";
$i             = 0;

$comment_array = array();

//전체 게시물 뽑음
$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_is_comment = '0' ORDER BY wr_num ASC";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
	$basic_list[$i][$row['wr_num']] = $row['wr_id'];
	$num_list[] = $row['wr_num'];
	$i++;
}

$min = min($num_list);
$max = max($num_list);

//선택된 인덱스 저장
$temp = $basic_list[$_POST['current']];

//선택된 인덱스부분 삭제
unset($basic_list[$_POST['current']]);

//처음부터 선택된 인덱스까지 자름
$arr_front = array_slice($basic_list, 0, $_POST['desired']); 

//선택된 인덱스 부터 마지막까지 자름
$arr_end = array_slice($basic_list, $_POST['desired']); 

// 앞부분 배열 맨뒤에 선택된 인덱스 삽입
$arr_front[] = $temp;

// 앞부분과 뒷부분 배열 합침 
$basic_list = array_merge($arr_front, $arr_end);

// 바뀐 순서대로 wr_num 재정렬
for ($k=0; $k < count($basic_list); $k++) { 
	foreach ($basic_list[$k] as $key => $value) {
		$sql = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$min}' WHERE wr_id='{$value}'";
		sql_query($sql);
	}
	$min++;
}



/***********************************댓글 순서 바꾸기************************************/

$sql = "SELECT wr_parent,wr_id FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_is_comment = '1'";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
	$sql = "SELECT wr_num FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_parent = '{$row['wr_parent']}' AND wr_is_comment = '0'";
	$fetch = sql_fetch($sql);
	
	$sql = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$fetch['wr_num']}' WHERE wr_id='{$row['wr_id']}'";
		sql_query($sql);
}





echo json_encode($basic_list);
?>
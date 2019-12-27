<?
$reserved_array = array();
$start_cul_array = array();
$end_range_array = array();
$wrSubjectArray = array();



$functions = new Functions();

//메타테이블 셋팅 정보 가져옴
$result = $functions->callMetaTable("settings/".$board['bo_1']);
for ($i=0; $i < count($result); $i++) { 

	$settingsArray[$result[$i]['mta_db_id']] = $result[$i]['mta_key'];
}

// 환경설정 관리자 방막기
$result = $functions->callMetaTable("settings/".$board['bo_1'], 'setting3');
$closed_setting = $result[0]['mta_key'];

//개인정보 약관 정보 불러옴
$sql = "SELECT * FROM {$g5['board_table']} WHERE bo_table = '{$board['bo_1']}'";
$agree = sql_fetch($sql);



?>
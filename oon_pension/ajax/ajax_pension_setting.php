<?
include_once("./_common.php");

//_booking 테이블 셋팅
$reservation = sql_fetch("SELECT bo_table FROM {$g5['board_table']} WHERE bo_skin = 'theme/_reservation'");

$sql = "UPDATE {$g5['board_table']} SET 
										bo_image_width = '850',
										bo_write_level = '8',
										bo_use_dhtml_editor = '1',
										bo_upload_count = '10',
										bo_1 = '{$reservation['bo_table']}'
										WHERE bo_table = '{$_POST['bo_table']}'";
sql_query($sql);


//_reservation 셋팅

$sql = "UPDATE {$g5['board_table']} SET bo_reply_level = '8',
										bo_comment_level = '8',
										bo_use_dhtml_editor = '1',
										bo_1 = '{$_POST['bo_table']}'
										WHERE bo_table = '{$reservation['bo_table']}'";
sql_query($sql);

// $sql = "CREATE TABLE `g5_pension_options` (
// 			  `op_id` bigint(20) NOT NULL,
// 			  `op_key` varchar(50) NOT NULL,
// 			  `op_name` varchar(50) NOT NULL,
// 			  `op_count` varchar(255) NOT NULL,
// 			  `op_price` varchar(200) NOT NULL,
// 			  `op_reg_dt` datetime DEFAULT '0000-00-00 00:00:00'
// 			) ENGINE=MyISAM DEFAULT CHARSET=utf8";


$sql = "CREATE TABLE `g5_pension_options` (
			  `op_id` int(11) NOT NULL,
			  `op_wr_id` varchar(255) NOT NULL,
			  `op_key` varchar(50) NOT NULL,
			  `op_name` varchar(50) NOT NULL,
			  `op_count` varchar(255) DEFAULT NULL,
			  `op_price` varchar(200) DEFAULT NULL,
			  `op_reg_dt` datetime DEFAULT '0000-00-00 00:00:00'
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
sql_query($sql);

echo json_encode($sql);
?>
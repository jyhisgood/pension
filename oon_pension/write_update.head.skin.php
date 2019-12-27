<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($w == 'u') {
	$sql = "DELETE FROM {$g5['meta_table']} WHERE mta_db_id = '{$wr_id}' AND mta_key LIKE '%wr_option_%' AND mta_db_table = 'board/{$board['bo_table']}'";
	sql_query($sql);
}


?>
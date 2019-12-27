<?php
 include_once('./_common.php');
 include_once $board_skin_path . "/lib/thumbnail.lib.php";
$file = get_file($_POST['bo_table'],$_POST['wr_id']);



$append = "";
$append .= "<div id=\"slideshow\" style='max-width:100%;'>
            <ul class='pgwSlideshow'>
            \n";
// <img src="'.$file[$i][path]."/".$file[$i][file].'" />
for ($i=0; $i < $file['count']; $i++) { 
	$img_tag = '<img src="'.$file[$i][path]."/".$file[$i][file].'" style="width:100%">';
	$append .= get_view_thumbnail2($img_tag);
}
$append .= "</ul></div>\n";

echo json_encode($append);
?>
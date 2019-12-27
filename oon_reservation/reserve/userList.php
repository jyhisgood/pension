<?

if (isset($_SESSION['checkingReservation'])) {
	$data = base64_decode($_SESSION['checkingReservation']);
	$data = explode("|", $data);
	$_POST['username'] = $data[0];
	$_POST['phone'] = $data[1];
	// $_POST['listcount'] = $data[2];

	$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} WHERE wr_2 = '{$_POST['username']}' AND wr_1 = '{$_POST['phone']}'";
	// echo $sql;
	$rs = sql_query($sql);
	$_POST['listcount'] = sql_num_rows($rs);
	
}else{
	if ($_POST) {
		$pension_cookie = base64_encode($_POST['username'].'|'.$_POST['phone'].'|'.$_POST['listcount']);
		$_SESSION['checkingReservation'] = $pension_cookie;
	}else{
		alret("잘못된 접근입니다.");	
	}
	
}

if ($_POST['listcount'] == 1) {
	$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} WHERE wr_1 = '{$_POST['phone']}' AND wr_2 = '{$_POST['username']}'";
	$view = sql_fetch($sql);
	goto_url($_SERVER['REQUEST_URI']."&wr_id=".$view['wr_id']);
}else{

	$userList = array();

	$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} WHERE wr_1 = '{$_POST['phone']}' AND wr_2 = '{$_POST['username']}'";
	$result = sql_query($sql);
	while ($row = sql_fetch_array($result)) {
		$userList[] = $row;
	}
}

?>

<div class="tbl_head01 tbl_wrap">
	
	<table>
		<thead>
			<tr>
				<th scope="col" style="width: 50px;">번호</th>
		        <th scope="col" style="width: 200px;">객실명</th>
		        <th scope="col" style="width: 150px;">총예약금액</th>
				<th scope="col" style="width: 150px;">입실날짜</a></th>
				<th scope="col" style="width: 150px;">퇴실날짜</a></th>
				<th scope="col" style="width: 100px;">상태</th>
				<th scope="col" style="width: 100px;">작성일</a></th>
			</tr>
		</thead>
		<tbody>
			<?for ($i=0; $i < count($userList); $i++) {

				$roomName = explode("|", $userList[$i]['wr_5']);
				$checkIn = explode("|", $userList[$i]['wr_9']);	
				$checkOut = explode("|", $userList[$i]['wr_10']);
				$userList[$i]['wr_8'] = str_replace(",", '', $userList[$i]['wr_8']);
				$userList[$i]['wr_8'] = str_replace("원", '', $userList[$i]['wr_8']);
				$priceArr = explode("|", $userList[$i]['wr_8']);
				$price = 0;
				for ($p=0; $p < count($priceArr); $p++) { 
					$price += $priceArr[$p];
				}
				$roomName = explode("|", $userList[$i]['wr_5']);
				

			?>
				
			<tr>
				<td style="text-align: center;"><?=$i+1?></td>
				<td style="text-align: center;font-weight: bold;">
					<a href="./board.php?bo_table=<?=$bo_table?>&wr_id=<?=$userList[$i]['wr_id']?>">
						<?if (count($roomName) == 1) {
							echo $roomName[0];
						}else{
							echo $roomName[0]." 외 ".(count($roomName)-1);
						}?>
					</a>
				</td>
				<td style="text-align: center;">
					<?=number_format($price)."원"?>
				</td>
				<td style="text-align: center;">
					<?if (count($checkIn) == 1) {
						echo $checkIn[0];
					}else{
						echo $checkIn[0]." 외 ".(count($checkIn)-1);
					}?>
				</td>
				<td style="text-align: center;">
					<?if (count($checkOut) == 1) {
						echo $checkOut[0];
					}else{
						echo $checkOut[0]." 외 ".(count($checkOut)-1);
					}?>
				</td>
				<td style="text-align: center;">
					<?=$userList[$i]['wr_6']?>
				</td>
				<td style="text-align: center;">
					<?=date("Y-m-d", strtotime($userList[$i]['wr_datetime']))?>
				</td>
			</tr>	
			<?}?>
		</tbody>
	</table>
</div>
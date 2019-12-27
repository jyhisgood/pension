<?php
include_once(G5_LIB_PATH.'/icode.sms.lib.php'); 
/**
 * SMS 전송을 위한 오브젝트
 */
class SendSMS
{
	// private $g5;
	public  $useSMS = true;
	public $isLMS;
	public $icdeSMS;

	public $msg_status;
	public $wr_2;
	public $room;
	public $use_hp_mb;
	public $wr_8;
	public $date;
	public $uplus_sms;

	public $send_number;
	public $admin_number;
	public $use_number;


	function __construct()
	{

		global $g5;
		// $this->g5 = $g5;
		$sql = " SELECT * FROM g5_config";

		$this->uplus_sms = sql_fetch($sql);

		if ($this->uplus_sms['cf_10']=="") {
			$this->useSMS = false;
		}

		
	}


	//변수 저장
	function setSMS($informations)
	{
		$this->msg_status = $informations['wr_6']; 			      // 상태 ex)취소요청
		$this->wr_2       = $informations['wr_2']; 			      // 유저이름
		$this->room       = $informations['wr_5']; 			      // 객실명
		$this->use_hp_mb  = $informations['wr_1']; 			      // 사용자 전화번호 
		$this->wr_8       = $informations['wr_8']; 			      // 예약 가격
		$this->date       = $informations['wr_9'] . 			  // 기간
		                     " ~ " . $informations['wr_10'];      
	}
	function send()
	{	
		if ($this->useSMS) {
			$this->sendAsUplus();
		}else{
			return;
		}
		
	}

	function sendAsIcode()
	{
		
	}


	function sendAsUplus()
	{
		
		$use_smsid = $this->uplus_sms['cf_nct_sms_id']; // SMSID
		$use_smskey = $this->uplus_sms['cf_nct_sms_key']; // SMSkey 

		//관리자 문자 발송
		$send_hp_mb = $this->uplus_sms['cf_nct_sms_num']; // 발신 전화번호
		$admin_hp_mb = $this->uplus_sms['cf_nct_sms_sendnum']; // 관리자 전화번호 

		//소켓통신
		$info = parse_url("http://sms.nccj.kr/api/remind_count/".$use_smsid."/".$use_smskey);
		$fp = fsockopen($info['host'], 80);

		if($fp){
			$remindCountResult = "0";
			$parm = "";
			$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
			."Host: " . $info["host"] . "\r\n"
			. "Content-type: application/x-www-form-urlencoded\r\n"
			. "Content-length: " . strlen($parm) . "\r\n"
			. "Connection: close\r\n\r\n" . $parm."\r\n";

			fputs($fp, $send);
			
			while(!feof($fp)) $remindCountResult = fgets($fp, 128);

			$remindResult = json_decode($remindCountResult);

			$this->isLMS = $remindResult->msg_type;

			$remindCount = $remindResult->remind_count;
		}


		$send_hp = str_replace("-","",$send_hp_mb); // - 제거 
		$admin_hp = str_replace("-","",$admin_hp_mb); // - 제거 
		$use_hp = str_replace("-","",$this->use_hp_mb); // - 제거 



		
		$this->send_number =  "$send_hp"; // 사전등록번호
		$this->admin_number = "$admin_hp"; // 관리자 전화번호 
		$this->use_number = "$use_hp"; // 사용자 전화번호 

		$sms_message = $this->makeMessageToManager();

		if ($this->isLMS == 'LMS') {
			$sms_type = "lms";
		}else{
			$sms_type = "pension";
		}



		if($sms_message){
			$info = @parse_url("http://sms.nccj.kr/api/".$sms_type);
			$fp = @fsockopen($info['host'], 80);

			if($fp){
				$parm = "callbackHp=".$this->send_number."&smsHp=".$this->admin_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				// $parm = "callbackHp=".$admin_number."&smsHp=".$send_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				//echo $parm;
				$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
				."Host: " . $info["host"] . "\r\n"
				. "Content-type: application/x-www-form-urlencoded\r\n"
				. "Content-length: " . strlen($parm) . "\r\n"
				. "Connection: close\r\n\r\n" . $parm."\r\n";
				
				@fputs($fp, $send);
			}	
		}

		$sms_message = $this->makeMessageToUser();

		if($sms_message){
			$info = @parse_url("http://sms.nccj.kr/api/".$sms_type);
			$fp = @fsockopen($info['host'], 80);

			if($fp){
				$parm = "callbackHp=".$this->send_number."&smsHp=".$this->use_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				// $parm = "callbackHp=".$admin_number."&smsHp=".$use_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				//echo $parm;
				$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
				."Host: " . $info["host"] . "\r\n"
				. "Content-type: application/x-www-form-urlencoded\r\n"
				. "Content-length: " . strlen($parm) . "\r\n"
				. "Connection: close\r\n\r\n" . $parm."\r\n";
				
				@fputs($fp, $send);
			}	
		}

		
	}

	function makeMessageToManager()
	{
		if($this->msg_status == "예약대기") {
						
			if($this->uplus_sms['cf_1_subj']=="true") {
				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_1']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
				
			}

		}
		if($this->msg_status == "예약완료") {
			
			if($this->uplus_sms['cf_3_subj']=="true") {

				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_3']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
			}

		}
		if($this->msg_status == "취소요청") {
			
			if($this->uplus_sms['cf_5_subj']=="true") {
				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_5']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
			}

		}
		if($this->msg_status == "취소완료") {
			
			if($this->uplus_sms['cf_7_subj']=="true") {
				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_7']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
			}

		}
		

		return $sms_message;
	}


	function makeMessageToUser()
	{
		if($this->msg_status == "예약대기") {
						
			if($this->uplus_sms['cf_2_subj']=="true") {

				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_2']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
				
			}

		}
		if($this->msg_status == "예약완료") {
			
			if($this->uplus_sms['cf_4_subj']=="true") {

				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_4']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
			}

		}
		if($this->msg_status == "취소요청") {
			
			if($this->uplus_sms['cf_6_subj']=="true") {

				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_6']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
			}

		}
		if($this->msg_status == "취소완료") {
			
			if($this->uplus_sms['cf_8_subj']=="true") {

				$message_con = str_replace("{name}", $this->wr_2, $this->uplus_sms['cf_8']);
				$message_con = str_replace("{room}", $this->room, $message_con);
				$message_con = str_replace("{date}", $this->date, $message_con);
				$sms_message = str_replace("{price}", $this->wr_8, $message_con);
			}

		}
		

		return $sms_message;
	}



	

}
?>
<?php

/**
 * 
 */
class Holidays
{	
	protected $opts = array('TDCProjectKey: 6b43fc3e-1bc3-42c0-accb-6df0c1912aaa', 'Accept: application/json');
	
	private $url = "https://apis.sktelecom.com/v1/eventday/";
	
	public $holiday_data;
	
	public $data = array();

	function __construct()
	{
		global $g5;
		$holiday_date = array('2019-03-01'=>'3.1절',
							  '2019-05-05'=>'어린이날',
							  '2019-05-06'=>'대체휴일',
							  '2019-05-12'=>'석가탄신일',
							  '2019-06-06'=>'현충일',
							  '2019-08-15'=>'광복절',
							  '2019-09-12'=>'추석',
							  '2019-09-13'=>'추석',
							  '2019-09-14'=>'추석',
							  '2019-10-03'=>'개천절',
							  '2019-10-09'=>'한글날',
							  '2019-12-25'=>'크리스마스',
							  '2020-01-01'=>'신정',
							  '2020-01-24'=>'설날',
							  '2020-01-25'=>'설날',
							  '2020-01-26'=>'설날',
							  '2020-01-27'=>'대체휴일',
							  '2020-03-01'=>'3.1절',
							  '2020-04-15'=>'국회의원선거',
							  '2020-04-30'=>'석가탄신일',
							  '2020-05-05'=>'어린이날',
							  '2020-06-06'=>'현충일',
							  '2020-08-15'=>'광복절',
							  '2020-09-30'=>'추석',
							  '2020-10-01'=>'추석',
							  '2020-10-02'=>'추석',
							  '2020-10-03'=>'개천절',
							  '2020-10-09'=>'한글날',
							  '2020-12-25'=>'크리스마스',
							  '2021-01-01'=>'신정',
							  '2021-02-11'=>'설날',
							  '2021-02-12'=>'설날',
							  '2021-02-13'=>'설날',
							  '2021-03-01'=>'3.1절',
							  '2021-05-19'=>'석가탄신일',
							  '2021-05-05'=>'어린이날',
							  '2021-06-06'=>'현충일',
							  '2021-08-15'=>'광복절',
							  '2021-09-20'=>'추석',
							  '2021-09-21'=>'추석',
							  '2021-09-22'=>'추석',
							  '2021-10-03'=>'개천절',
							  '2021-10-09'=>'한글날',
							  '2021-12-25'=>'크리스마스',
							  '2022-01-01'=>'신정',
							  '2022-01-31'=>'설날',
							  '2022-02-01'=>'설날',
							  '2022-02-02'=>'설날',
							  '2022-03-01'=>'3.1절',
							  '2022-05-08'=>'석가탄신일',
							  '2022-05-05'=>'어린이날',
							  '2022-06-06'=>'현충일',
							  '2022-08-15'=>'광복절',
							  '2022-09-09'=>'추석',
							  '2022-09-10'=>'추석',
							  '2022-09-11'=>'추석',
							  '2022-10-03'=>'개천절',
							  '2022-10-09'=>'한글날',
							  '2022-12-25'=>'크리스마스',
							  '2023-01-01'=>'신정',
							  '2023-01-21'=>'설날',
							  '2023-01-22'=>'설날',
							  '2023-01-23'=>'설날',
							  '2023-03-01'=>'3.1절',
							  '2023-05-27'=>'석가탄신일',
							  '2023-05-05'=>'어린이날',
							  '2023-06-06'=>'현충일',
							  '2023-08-15'=>'광복절',
							  '2023-09-28'=>'추석',
							  '2023-09-29'=>'추석',
							  '2023-09-30'=>'추석',
							  '2023-10-03'=>'개천절',
							  '2023-10-09'=>'한글날',
							  '2023-12-25'=>'크리스마스'
	                    );
		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = 'holiday'";
		
        $result = sql_query($sql);
        while ($row = sql_fetch_array($result)) {
        	$holiday_date[$row['mta_value']] = $row['mta_key'];	
        	
        }
		
	    $const_data = array();
	    $name_temp = array();
	    foreach ($holiday_date as $key => $value) {
	        $name_temp = ['name' => $value];
	        $const_data[$key] = (object) $name_temp;
	    }
	    $this->holiday_data = $const_data;
	}


	public function getHolidayList($date)
	{
		//sk eventday api 사용시 *현재 서비스종료
		// $element1 = $this->getSocketURL($date);
		// $date = date("Y-m",strtotime('+1 month',strtotime($date)));
		// $element2 = $this->getSocketURL($date);
		// if (isset($element2)) {
		// 	$values = @array_merge($element1,$element2);
		// }else{
		// 	$values = $element1;
		// }

		$element1 = $this->getUserSetting($date);
		$date = date("Y-m",strtotime('+1 month',strtotime($date)));
		$element2 = $this->getUserSetting($date);
		if (isset($element2)) {
			$values = @array_merge($element1,$element2);
		}else{
			$values = $element1;
		}


		return $values;
	}

	public function getHolidayWeekend ($date) {
		$check_holi = 0;
		$holiday_list = $this->getHolidayList($date);
		
		$holi_next = date("Y-m-d",strtotime("+1 day", strtotime($date)));
		
		if (isset($holiday_list)) {
			$check_holi = array_key_exists($holi_next, $holiday_list);	
		}
		

		return $check_holi;
	}

	public function getUserSetting($date)
	{
		$date = date('Y-m',strtotime($date));
		foreach ($this->holiday_data as $key => $value) {
			if(strpos($key, $date) !== false) {  
			    $this->data[$key] = $value;
			}
		}

		return $this->data;


	}

	public function getCurlURL($date)
	{
		$path = $year = $month = $day = "";
		$data = array();

		$time_stamp = strtotime($date);

		$year = date("Y",$time_stamp);
		$month = date("m",$time_stamp);

		$path = $this->url."days?year=".$year."&month=".$month."&type=h";
		

		/*************** curl 로직 ****************/
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $path); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->opts);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		$object = json_decode(curl_exec($ch)); 

		if (curl_error($ch)){ 
		   exit('CURL Error('.curl_errno( $ch ).') '.curl_error($ch)); 
		} 
		curl_close($ch); 


		//공휴일 없음.
		if ($object->totalResult == 0) {
			
			return;
		}

		$count = $object->totalResult;

		for ($i=0; $i < $count; $i++) { 
			$date_format = $object->results[$i]->year.
										"-".$object->results[$i]->month.
										"-".$object->results[$i]->day;
			
			$data[$date_format] = $object->results[$i];
			
		}
		
		return $data;

	}
	


	function getSocketURL($date, $method = 'GET')
	{   
		$path = $year = $month = $day = "";
		

		$time_stamp = strtotime($date);

		$year = date("Y",$time_stamp);
		$month = date("m",$time_stamp);

		$url = $this->url."days?year=".$year."&month=".$month."&type=h";
		
	    // Initialize
	    $info   = parse_url($url);
	    $req    = '';
	    $data   = array();
	    $res    = '';
	    $line   = '';
	    $agent  = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';
	    $linebreak  = "\r\n";
	    $headPassed = false;
	 
	    // Setting Protocol
	    switch($info['scheme'] = strtoupper($info['scheme']))
	    {
	        case 'HTTP':
	            $info['port']   = 80;
	            break;
	 
	        case 'HTTPS':
	            $info['ssl']    = 'ssl://';
	            $info['port']   = 443;
	            break;
	 
	        default:
	            return false;
	    }
	 
	    // Setting Path
	    if(!$info['path'])
	    {
	        $info['path'] = '/';
	    }
	 
	    // Setting Request Header

	    switch($method = strtoupper($method))
	    {
	        case 'GET':
	            if($info['query'])
	            {
	                $info['path'] .= '?' . $info['query'];
	            }
	 
	            $req .= 'GET ' . $info['path'] . ' HTTP/1.1' . $linebreak;
	            $req .= 'Host: ' . $info['host'] . $linebreak;
	            $req .= 'User-Agent: ' . $agent . $linebreak;
	            $req .= 'TDCProjectKey: 6b43fc3e-1bc3-42c0-accb-6df0c1912aaa' . $linebreak;
	            $req .= 'Accept: application/json' . $linebreak;
	            $req .= 'Referer: ' . $url . $linebreak;
	            $req .= 'Connection: Close' . $linebreak . $linebreak;
	            break;
	 
	        case 'POST':
	            $req .= 'POST ' . $info['path'] . ' HTTP/1.1' . $linebreak;
	            $req .= 'Host: ' . $info['host'] . $linebreak;
	            $req .= 'User-Agent: ' . $agent . $linebreak; 
	            $req .= 'Referer: ' . $url . $linebreak;
	            $req .= 'Content-Type: application/x-www-form-urlencoded'.$linebreak; 
	            $req .= 'Content-Length: '. strlen($info['query']) . $linebreak;
	            $req .= 'Connection: Close' . $linebreak . $linebreak;
	            $req .= $info['query']; 
	            break;
	    }
	 
	    // Socket Open
	    $fsock  = @fsockopen($info['ssl'] . $info['host'], $info['port']);
	    if ($fsock)
	    {
	    	
	        fwrite($fsock, $req);
	        while(!feof($fsock))
	        {
	            $line = fgets($fsock, 128);
	            
	            if($line == "\r\n" && !$headPassed)
	            {
	                $headPassed = true;
	                continue;
	            }
	            if($headPassed)
	            {	

	                $res .= $line;
	            }
	        }
	        fclose($fsock);
	    }
	    
	    $object = json_decode($res);
	 	//공휴일 없음.
	 	
		if ($object->totalResult == 0) {
			
			return;
		}

		$count = $object->totalResult;

		for ($i=0; $i < $count; $i++) { 
			$date_format = $object->results[$i]->year.
										"-".$object->results[$i]->month.
										"-".$object->results[$i]->day;
			
			$data[$date_format] = $object->results[$i];
			
		}
		
		
	    return $data;

	}

}


?>
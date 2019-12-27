<?
/**
 * 
 */
class Functions
{
	
	private $g5;
	private $board;
	public  $data = array();
	

	function __construct()
	{
		global $g5;
		global $board;

		$this->g5            = $g5;
		$this->board         = $board;
		
	}

	// bo_1 테이블 데이터를 가져옴
	function callBo1Table($wr_id = "" ,$fetch = false)
	{	

		$i = 0;
		$data = array();
		if ($wr_id != "") {
			$query = "WHERE wr_id = '{$wr_id}'";
		}
		$sql = "SELECT * FROM {$this->g5['write_prefix']}{$this->board['bo_1']} {$query}";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result)) {
			
			$metaSql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->board['bo_1']}' AND mta_db_id = '{$row['wr_id']}'";
			$metaResult = sql_query($metaSql);

			while ($metaRow = sql_fetch_array($metaResult)) {
				$row[$metaRow['mta_key']] = $metaRow['mta_value'];		
			}
			if ($fetch == true) {
				$data = $row;
			}else{
				$data[] = $row;
			}
			
		}

		return $data;
	}

	// 현재 테이블의 데이터를 가져옴
	function callThisTable($wr_id = "")
	{
		$i = 0;
		if ($wr_id != "") {
			$query = "WHERE wr_id = '{$wr_id}'";
		}
		$sql = "SELECT * FROM {$this->g5['write_prefix']}{$this->board['bo_table']} {$query}";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result)) {

			$metaSql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = 'board/{$this->board['bo_table']}' AND mta_db_id = '{$row['wr_id']}'";
			$metaResult = sql_query($metaSql);

			while ($metaRow = sql_fetch_array($metaResult)) {
				$row[$metaRow['mta_key']] = $metaRow['mta_value'];		
			}

			$this->data[] = $row;

		}

		return $this->data;
	}

	// 메타데이터를 가져옴
	function callMetaTable($dbTable, $id = "", $key = "")
	{	
		$metaTable = array();
		$query = "";
		if ($id != "") {
			$query .= "AND mta_db_id = '{$id}'";			
		}
		if ($key != "") {
			$query .= " AND mta_key = '{$key}'";	
		}

		$sql = "SELECT * FROM {$this->g5['meta_table']} WHERE mta_db_table = '{$dbTable}' {$query}";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result)) {
			$metaTable[] = $row;
		}

		return $metaTable;
	}
	

	


}
?>
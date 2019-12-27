<?
include_once ($board_skin_path."/default.php");
include_once (PENSION_SKIN_PATH."/classes/Rooms.php");
/**
 * 사용자가 선택한 옵션 정보들을 가져옴
 */

class Options extends Rooms
{
	private $g5;
	private $board;
	public $thisId;
	public $reservedId;
	public $data = array();

	function __construct()
	{
		global $g5;
		global $board;

		$this->g5 = $g5;
		$this->board = $board;

	}

	function setReservedData($thisId, $reservedId)
	{
		$this->thisId     = $thisId;
		$this->reservedId = $reservedId;
	}

	function getReservedOptions()
	{
	
		$this->data = array();
		$sql = "SELECT * FROM g5_pension_options WHERE op_wr_id = '{$this->thisId}' AND op_key = '{$this->reservedId}'";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result)) {
			$this->data[] = $row;
		}

		return $this->data;
	}

}
?>
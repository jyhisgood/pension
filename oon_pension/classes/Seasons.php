<?
/**
 * 	
 */
class Seasons
{

	function __construct()
	{
		// ..code
	}

	function getSeasonList($g5)
	{
		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'date/config'";
		$result = sql_query($sql);
		$i = 0;

		while ($row = sql_fetch_array($result)) {

		    $dateConfig[$i]['date_name'] = $row['mta_db_id'];
		    $dateConfig[$i]['start_date'] = $row['mta_key'];
		    $dateConfig[$i]['end_date'] = $row['mta_value'];
		    $i++;

		}

		return $dateConfig;
	}

	
}
?>
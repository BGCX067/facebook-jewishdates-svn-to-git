<?
require_once 'passiveRecord.php';
class UserRecord extends PassiveRecord
{
	public $tableName='fbUsers';
	public $collumns = array('appid', 'current', 'sessionId', 'sessionExpires');
}
?>
<?
require_once 'passiveRecord.php';
require_once 'userRecord.php';
class DateRecord extends PassiveRecord
{
	public $tableName='fb_jd_moreDates';
	public $collumns = array('uid', 'title', 'originalDate', 'hebrewDate', 'nextDate', 'night', 'created_at');

	public function save()
	{
		$this->data['originalDate'] = date( 'Y-m-d', strtotime($this->data['originalDate']) );
		if($this->data['originalDate'] == date( 'Y-m-d', strtotime('') ) )
		{
			$this->errors['originalDate'] = 'Sorry, the computer could not understand the date you submitted.';
			return false;
		}
		if($this->data['title'] == '')
		{
			$this->errors['title'] = 'This field can not be blank.';
			return false;
		}
		return parent::save();
	}
	public function getOriginalDate($format='long')
	{
		return date( 'M dS Y', strtotime($this->data['originalDate']));
	}
	public function getHebrewDate($format='shorteng')
	{
		$bornAtNight=$this->data['night'];
		switch(strtolower($format)){
			case 'shorteng':
				return strGregToHeb($this->data['originalDate'], false, $bornAtNight);
				break;
			case 'longeng':
				$ahebdate = explode("/", strGregToHeb($this->data['originalDate'], false, $bornAtNight));
				return $ahebdate[1] . " " . getJewishMonthName($ahebdate[0], $ahebdate[2]) . " " . $ahebdate[2];
				break;
			case 'medeng':
				$ahebdate = explode("/", strGregToHeb($this->data['originalDate'], false, $bornAtNight));
				return $ahebdate[1] . " " . getJewishMonthName($ahebdate[0], $ahebdate[2]);
				break;
			case 'shortheb':
				return strGregToHeb($this->data['originalDate'], true, $bornAtNight);
				break;
			case 'longheb':
				return "Not Implemented";
				break;
		}
	}
	public function getNextOccurance()
	{
		$ahebdate = explode("/", strGregToHeb($this->data['originalDate'], false, $this->data['night']) );
		return dateThisYear($ahebdate);
	}
	public function getUserRecord()
	{
		$userRecords = UserRecord::findByWhere('UserRecord',"appid='4e703411e9ad1935a923475be4271d65' and id=".$this->data['uid']);
		return $userRecords[0];
	}
}
?>

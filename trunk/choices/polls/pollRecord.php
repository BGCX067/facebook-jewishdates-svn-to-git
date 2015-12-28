<?
require_once '../inc/passiveRecord.php';
require_once '../questions/questionRecord.php';
class PollRecord extends PassiveRecord
{
	public $tableName='fb_ch_polls';
	public $collumns = array('title', 'notes', 'type');
	public $questions;
	
	public function getQuestions()
	{
		$data = $this->data;
		if($questions == null)$questions = QuestionRecord::findByWhere('QuestionRecord', "q.poll_id=$data[id]");
		return $questions;
	}
	
	public function addQuestion($title, $type)
	{
		$q = new QuestionRecord(array('poll_id' => $this->data['id'], 'title' => $title, 'type' => $type));
		$questions[] = $q;
		$q.save();
		return $q;
	}
	
	public function vote($uid, $question_id, $vote)
	{
		$conn = dbConnect();
		$sql =	"REPLACE INTO fb_ch_votes (poll_id, question_id, user_id, `value`)	"
			.	"VALUES ($this->data[id], $question_id, $uid, $vote)";
		$results = mysql_query($sql,$conn);
		echo(mysql_error($conn));
		mysql_close($conn);
	}
	
	public static function createEventPoll()
	{
		$conn = dbConnect();
		$sql = "INSERT INTO fb_ch_events (title, notes) VALUES ('$_REQUEST[title]', '$_REQUEST[notes]')";
		$results = mysql_query($sql,$conn);
		echo(mysql_error($conn));
		$insertedId = mysql_insert_id($conn);
		$sql = "INSERT INTO fb_ch_questions (event_id,title) VALUES ";
		for( $i=$_REQUEST["start"]; $i<$_REQUEST["stop"]; $i++ )
		{
			$sql .= "($insertedId, '$i:00'),($insertedId, '$i:15'),($insertedId, '$i:30'),($insertedId, '$i:45'),";
		}
		$sql = substr($sql, 0, strlen($sql)-1);
		$results = mysql_query($sql,$conn);
		echo(mysql_error($conn));
		mysql_close($conn);		
	}
}
?>

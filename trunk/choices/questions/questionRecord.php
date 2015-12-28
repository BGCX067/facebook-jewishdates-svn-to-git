<?
require_once '../inc/passiveRecord.php';
class QuestionRecord extends PassiveRecord
{
	public $tableName='fb_ch_questions';
	public $collumns = array('poll_id', 'title', 'type');
	
	public $score, $count;
	
	public function update($tHash)
	{
		parent::update($tHash);
		$score = $tHash['score'];
		$count = $tHash['count'];
	}
	
	public static function findByWhere($className, $sqlWhere)
	{
		return self::findBySQL($className,
			"SELECT q.`id`,q.`title`,q.`type`,q.`created_at`,q.`updated_at`, count(v.id) count, sum(v.value) score	"
		  .	"FROM fb_ch_questions q LEFT JOIN fb_ch_votes v ON q.id=v.question_id	"
		  .	"WHERE $sqlWhere	"
		  .	"GROUP BY q.`id`,q.`title`,q.`type`,q.`created_at`,q.`updated_at`	");
	}
}
<?
error_reporting(E_ALL);
require_once 'appinclude.php';

	if(isset($_REQUEST["submit"]))
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
		$conn = dbConnect();
		$sql = "SELECT * FROM fb_ch_questions q LEFT JOIN fb_ch_votes v ON q.id=v.question_id";
		$results = mysql_query($sql,$conn);
		echo(mysql_error($conn));
			
?>
<form action="" method="">
	<? while( $rs = mysql_fetch_assoc($results)){ ?>
	<? print_r($rs); ?>
		<div class="question">
			<div class="questionTitle">
				<?=$rs['title']?>
			</div>
			<div class="choices">
				<label class="label1" for="<?=$rs['question_id']?>1">Won't Work</label>
				<input type="radio" value="-1" name="<?=$rs['question_id']?>" id="<?=$rs['question_id']?>1"/>
				<label class="label2" for="<?=$rs['question_id']?>2">Kinda</label>
				<input type="radio" value="0" name="<?=$rs['question_id']?>" id="<?=$rs['question_id']?>2"/>
				<label class="label3" for="<?=$rs['question_id']?>3">Works Great!</label>
				<input type="radio" value="1" name="<?=$rs['question_id']?>" id="<?=$rs['question_id']?>3"/>
			</div>
		</div>
	<? } ?>
</form>

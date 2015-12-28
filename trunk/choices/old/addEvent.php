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
		mysql_close();		
	}
?>
<form action="" method="">
	<input name="title" value="" size="20" />
	<input name="notes" value="" size="20" />
	<input name="start" value="" size="20" />
	<input name="stop" value="" size="20" />
	<p><input type="submit" value="Continue" name="submit" /></p>
</form>
<? print_r($facebook); print_r($_REQUEST); ?>
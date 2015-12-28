<?
$noframe=true;
require_once 'appinclude.php';

$conn = dbConnect();	
if(isset($_REQUEST['id']))
{
	$messageid=$_REQUEST['id'];
	$result = mysql_query("SELECT * FROM fb_messages WHERE id=$messageid");
	echo mysql_error($conn);
	$rs = mysql_fetch_assoc($result);
	print_r($rs);
	$message 		= $rs['message'];
	$titleEmail 	= $rs['emailTitle'];
	$messageEmail1 	= $rs['emailHTML'];
	$messageEmail2	= $rs['emailText'];
}else{
	$message_sql = mysql_real_escape_string(
		$message 		= $_REQUEST['message'] );
	$titleEmail_sql = mysql_real_escape_string(
		$titleEmail 	= $_REQUEST['titleEmail'] );
	$messageEmail1_sql = mysql_real_escape_string(
		$messageEmail1 	= $_REQUEST['messageEmailHTML'] );
	$messageEmail2_sql = mysql_real_escape_string(
		$messageEmail2	= $_REQUEST['messageEmailText'] );
	$sql = "INSERT INTO fb_messages (message, emailTitle, emailHTML, emailText) VALUES ('$message_sql','$titleEmail_sql', '$messageEmail1_sql','$messageEmail2_sql')";
	mysql_query($sql);
	echo $sql;
	echo mysql_error($conn);
	$messageid=mysql_insert_id();
}
mysql_close($conn);
	$allUsers		= !isset($_REQUEST['oneUser']);
	$messageType	= isset($_REQUEST['messageType']) ? $_REQUEST['messageType'] : $_REQUEST['sendNotification'] + $_REQUEST['sendEmail'];	//	1=Notice, 2=Email, 3=Both;
	$startLimit = isset($_REQUEST['startLimit']) ? $_REQUEST['startLimit'] : 0;
	$endLimit = isset($_REQUEST['endLimit']) ? $_REQUEST['endLimit'] : 0;

$batch=false;
$subBatchSize = 10;
$batchSize = 10;
$noRepeat = true;
$giveFeedback = 'SaveStatusToDB';

include '../facebookIncludes/postNotificationsWithBatch.php';

if($i > 1) {
	?>
<script>
	window.location = "?id=<?=$messageid?>&startLimit=<?=$startLimit+$endLimit?>&endLimit=<?=$endLimit?>&messageType=<?=$messageType?>";
</script>
<? } ?>
<?
	function PrintStatus($i)
	{
		echo '<pre>';
		print_r($i);
		echo '</pre>';
	}
	function SaveStatusToDB($i)
	{
		global $messageid;
		if($i % 10 != 0)return;
		$count = $_REQUEST['startLimit'] + $i;
		$conn = dbConnect();
		$body = mysql_real_escape_string($_REQUEST['titleEmail'], $conn);
		mysql_query("UPDATE fb_messages SET count=$count WHERE id=$messageid", $conn);
		echo mysql_error($conn);
		mysql_close($conn);
		PrintStatus($i);
	}
?>
<?php
//error_reporting(0);
require_once 'appinclude.php';
require_once 'jDateFunctions.php';

$titleEmail = 'We areupgrading Jewish Dates';
$message = "We are working hard to upgrade <a href='http://apps.new.facebook.com/jewishdates/'>Jewish Dates</a> to take advantage of the new profile. The only thing you need to do is visit (any) one of the <a href='http://apps.new.facebook.com/jewishdates/'>Jewish Dates</a> pages, and your profile will be upgraded. (You may need to do this again as we add features.)";
$messageEmail1 = $message . "";
$messageEmail2 = $message . "";

$allUsers=true;
$messageType = 3;	//	1=Notice, 2=Email, 3=Both;
$startLimit = isset($_REQUEST['startLimit']) ? $_REQUEST['startLimit'] : 0;
$endLimit = 500;
$i=0;

	if(!$allUsers)
	{
		$sql = "SELECT * FROM fbUsers WHERE current=1 AND appId='$appapikey' AND id='$user' Limit $startLimit, $endLimit";
	}
	if($allUsers)
	{
		$sql = "SELECT * FROM fbUsers WHERE current=1 AND appId='$appapikey' Limit $startLimit, $endLimit";
	}
		echo $sql;
		echo '<a href="?startLimit='.($startLimit+$endLimit).'">Next --&gt;</a>';
		$conn = dbConnect();
		$results = mysql_query($sql, $conn);
		while($rs = mysql_fetch_assoc($results))
		{
			//$message = sprintf($messageFormat,$facebook->user);
			try{
				if($messageType == 1 || $messageType == 3)
					$facebook->api_client->notifications_send_announce($rs['id'], $message);
				if($messageType == 2 || $messageType == 3)
					$facebook->api_client->notifications_sendEmail($rs['id'], $titleEmail, $messageEmail2, $messageEmail1);

				$i++;
			}catch(FacebookRestClientException $e){
				print_r($e);
			}
			echo "<h4>Message Posted to user $facebook->user #$i</h4>";
			if($i % 20 == 0) flush();
		}
		echo '<a href="?startLimit='.($startLimit+$endLimit).'">Next --&gt;</a>';
	if($i > 1){
?><script>location="?startLimit=<?=$startLimit+$endLimit?>";</script><?
	}
	?>
<fb:succes><fb:message>Success, sent to <?=$i?> users</fb:message></fb:succes>

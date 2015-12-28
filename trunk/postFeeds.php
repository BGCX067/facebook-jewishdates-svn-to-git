<?php
//error_reporting(0);
require_once 'appinclude.php';
require_once 'jDateFunctions.php';


$picture = $appcallbackurl.'images/raffle%20100.jpg';
$pLink = 'http://www.ChabadOfNewPaltz.com/660869';
$title = 'Help support Chabad of New Paltz and you might <a href="'. $pLink . '">win $10K</a>';
$titleEmail = 'Help support Chabad of New Paltz and you might win $10K';
$message = "Chabad of New Paltz is hosting a fundraising raffle. <a href='$pLink'>Click here to buy a ticket or five</a>. Tickets $36. This will also help improve Jewish applications on facebook.";
$messageEmail1 = $message . "";
$messageEmail2 = $message . "\n$pLink";

$allUsers=true;
$messageType = 'toUser';
$startLimit = isset($_REQUEST['startLimit']) ? $_REQUEST['startLimit'] : 0;
$endLimit = 500;
$i=0;

			//$message = sprintf($messageFormat,$facebook->user, $facebook->user);
			//$pLink = sprintf($pLinkFormat, $facebook->user);
	if(!$allUsers)
	{
		echo $message . '<br />' . $picture;
		$facebook->api_client->feed_publishStoryToUser($title, $message, $picture, $pLink);
		$facebook->api_client->notifications_sendEmail($user, $titleEmail, $messageEmail2, $messageEmail1);
	}
	if($allUsers)
	{
		$sql = "SELECT * FROM fbUsers WHERE current=1 AND sessionId is not null AND appId='$appapikey' Limit $startLimit, $endLimit";
		echo $sql;
		echo '<a href="?startLimit='.($startLimit+$endLimit).'">Next --&gt;</a>';
		$conn = dbConnect();
		$results = mysql_query($sql, $conn);
		while($rs = mysql_fetch_assoc($results))
		{
			$facebook->user = $rs['id'];
			$facebook->api_client->session_key = $rs['sessionId'];
			//$message = sprintf($messageFormat,$facebook->user);
			//$pLink = sprintf($pLinkFormat,$facebook->user);
			try{
				$facebook->api_client->feed_publishStoryToUser($title, $message, $picture, $pLink, null, null, null, null, null, null);
				$facebook->api_client->notifications_sendEmail($rs['id'], $titleEmail, $messageEmail2, $messageEmail1);

				$i++;
			}catch(FacebookRestClientException $e){
				markSessionExpired($rs['id']);
				print_r($e);
			}
			echo "<h4>Message Posted to user $facebook->user #$i</h4>";
			if($i % 20 == 0) flush();
		}
	}
		echo '<a href="?startLimit='.($startLimit+$endLimit).'">Next --&gt;</a>';
	if($i > 1){
?><script>location="?startLimit=<?=$startLimit+$endLimit?>";</script><?
	}
	
	function markSessionExpired($id)
	{
		$conn = dbConnect();
		$sql = 	 " UPDATE fbUsers SET `sessionExpires`='" . date("Y-m-d",strtotime('yesterday')) . "' WHERE id='$id'";
		mysql_query($sql, $conn);
		mysql_close($conn);
	}
?>
<fb:succes><fb:message>Success, sent to <?=$i?> users</fb:message></fb:succes>
<fb:google-analytics uacct="UA-2420747-2" />

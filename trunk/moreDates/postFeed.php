<?php
error_reporting(E_ALL);
$noframe = true;
$debug=true;
	require_once dirname(__FILE__) . '/../appinclude.php';
	require_once dirname(__FILE__) . '/helpers.php';

	$allUsers=true;
	$activeDate = isset($_REQUEST['date']) ? strtotime($_REQUEST['date']) : strtotime("now");
	$title = "Its a special day";
	$message = 	"Today is %1\$s which means that for you it is %2\$s. \n"
			.	"You can change this information or add more special dates at http://apps.facebook.com/jewishdates/moreDates";
	$messageHTML = "Today is %1\$s which means that for you it is %2\$s. \n"
			.	"You can change this information or add more special dates <a href='http://apps.facebook.com/jewishdates/moreDates>here</a>";
	$templateBundleId = 39811851889;
	$picture = 'http://www2.newpaltz.edu/~plotkinm/php/facebook/jewishdates/Icon75x75.gif';
	$pLink='http://apps.facebook.com/jewishdates/supportChabadOfNewPaltz.php';
	
	//generate coresponding dates
	$cDates = array();
	$aTodayHebrew = explode("/", strGregToHeb( date("M d, Y", $activeDate) ) );
	for($i=0; $i < 70; $i++)
	{
		$cdate=date("Y-m-d",strtotime(jdtogregorian(jewishtojd($aTodayHebrew[0], $aTodayHebrew[1], $aTodayHebrew[2]-$i))));
		$cDates[$i] = $cdate;
	}
	$cDatesStr = join("','",$cDates);
	
		$iLimit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 0 ;
		$iStopLimit =  isset($_REQUEST['toLimit']) ? $_REQUEST['toLimit'] : 300;
		$i=0; $actualPosts=0;
		?><h1><a href="?limit=<?=$iLimit+$iStopLimit?>">Next -></a></h1><?
		flush();
		$specialDays = DateRecord::findByWhere('DateRecord',"originalDate in('$cDatesStr') LIMIT  $iLimit, $iStopLimit");
		print_r_debug($specialDays);
		foreach($specialDays as $rs)
		{
			$userRecord = $rs->getUserRecord();
			$facebook->user = $rs->data['uid'];
			$facebook->api_client->session_key = $userRecord->data['sessionId'];
			try{
				generateAndPublishFeed($rs);
				$i++;
			}catch(FacebookRestClientException $e){
				print_r($e);
			}

			if($i % 20 == 0){ob_flush();flush();}
		}
		?><h1><a href="?limit=<?=$iLimit+$iStopLimit?>">Next -></a></h1>
        <? if($i > 1){ ?>
		<script language="javascript">
			window.location = "?limit=<?=$iLimit+$iStopLimit?>";
		</script>
		<? }
		
function generateAndPublishFeed($rs)
{
	global 	$facebook, $title, $message, $actualPosts, $templateBundleId, $picture, $pLink;
	$id = $rs->data['uid'];
		echo '<h6>Actual posts: ' . $actualPosts++ .'</h6>';
	$facebook->api_client->batch_queue = null;
	$facebook->api_client->begin_batch();
	$message2 = sprintf($message, $rs->getHebrewDate('medeng'), $rs->data['title'] );
	$messageHTML2 = sprintf($messageHTML, $rs->getHebrewDate('medeng'), $rs->data['title'] );
	//echo $message2;
	$facebook->api_client->notifications_send_announce($facebook->user, $messageHTML2);
	$facebook->api_client->notifications_sendEmail($facebook->user, $title, $message2, $messageHTML2 );
	$messageData = json_encode(array(	"title" => $rs->data['title'], "hebrewDate" => $rs->getHebrewDate('medeng'), "originalDate" => $rs->data['originalDate'], "nextOccurance" => $rs->getNextOccurance(),
										"images" => array(array ("src" => $picture, "href" => $pLink))));
	$facebook->api_client->feed_publishUserAction($templateBundleId, $messageData);
	print_r_debug($messageData);
	$facebook->api_client->end_batch();
}

function trace($str)
{
	echo '<h6>'. $str . ' - ' . date("h:i:s",time()) . "</h6>\n";
}
?>
Success, sent to <?=$i?> users

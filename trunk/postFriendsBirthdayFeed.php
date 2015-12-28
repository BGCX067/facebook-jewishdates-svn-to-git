<?php
error_reporting(E_ALL);
$noframe = true;
$debug=true;
require_once 'appinclude.php';
require_once 'jDateFunctions.php';

	$allUsers=true;
	$activeDate = isset($_REQUEST['date']) ? strtotime($_REQUEST['date']) : strtotime("now");
	$title = "Its your friend's Jewish Birthday";
	$message = 	"Today (%1\$s) is %2\$s's Jewish Birthday. \n"
			.	"You can buy %3\$s a Jewish Gift at http://www.judaism.com/index.asp?aref=mplotkin \n"
			.	"or send %3\$s a message on Facebook at http://apps.facebook.com/jewishdates/birthdayInfo.php?id=%4\$s\n\n"
			.	'If you do not wish to receive these messages. Please set your preferences at http://apps.facebook.com/jewishdates/messageSettings.php.';
	$messageHTML = 	'Today (%1$s) is <a href="http://apps.facebook.com/jewishdates/birthdayInfo.php?id=%4$s">%2$s</a>\'s Jewish Birthday. '
			.		'<br />You can buy %3$s a <a href="http://www.judaism.com/index.asp?aref=mplotkin">Jewish Gift</a> '
			.		' or send %3$s <a href="http://apps.facebook.com/jewishdates/birthdayInfo.php?id=%4$s">a message on Facebook</a>.<br /><br />'
			.		'	<hr />  '
            .       'Support Chabad Of New Paltz & the Jewish Facebook applications and win 10 Thousand $$$.<br>'
            .       '<a href=http://www.JewPaltz.com/raffle>Buy a raffle ticket or ten NOW</a>.';
	$one_line_story = array('{*actor*} has {*ammount*} friends whose <a href="http://apps.facebook.com/jewishdates/">Jewish Birthdays</a> are today({*today*}).',
							'{*actor*} has friends whose <a href="http://apps.facebook.com/jewishdates/">Jewish Birthdays</a> are today({*today*}).');
	$short_story = array(
						array(	'template_title'   => '{*actor*} has {*ammount*} friends whose <a href="http://apps.facebook.com/jewishdates/">Jewish Birthdays</a> are today({*today*}).',
						  		'template_body'    => 'You can add your <a href="http://apps.facebook.com/jewishdates/">Jewish Birthday</a>, the current Hebrew Date and other <a href="http://apps.facebook.com/jewishdates/">Jewish Dates</a> to your profile and get notified about your friends\' Jewish Bithdays with the <a href="http://apps.facebook.com/jewishdates/">Jewish Date Application</a>.'),
						array(	'template_title'   => '{*actor*} has friends whose Jewish Birthdays are today({*today*}).',
						  		'template_body'    => 'You can add your <a href="http://apps.facebook.com/jewishdates/">Jewish Birthday</a>, the current Hebrew Date and other <a href="http://apps.facebook.com/jewishdates/">Jewish Dates</a> to your profile and get notified about your friends\' Jewish Bithdays with the <a href="http://apps.facebook.com/jewishdates/">Jewish Date Application</a>.')
						);
	$full_story = $short_story;
	$templateBundleId = $facebook->api_client->feed_registerTemplateBundle($one_line_story, $short_story, $full_story);
	$picture = 'http://www2.newpaltz.edu/~plotkinm/php/facebook/jewishdates/Icon75x75.gif';
	$pLink='http://apps.facebook.com/jewishdates/supportChabadOfNewPaltz.php';
	
	//generate coresponding dates
	$cDates = array();
	$aTodayHebrew = explode("/", strGregToHeb( date("M d, Y", $activeDate) ) );
	for($i=10; $i < 70; $i++)
	{
		$cdate=date("F d, Y",strtotime(jdtogregorian(jewishtojd($aTodayHebrew[0], $aTodayHebrew[1], $aTodayHebrew[2]-$i))));
		$cDates[$i] = $cdate;
	}
	$cDatesStr = join("','",$cDates);
	$activeDateStr = date("l M d, Y", $activeDate);

		$iLimit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 0 ;
		$iStopLimit =  isset($_REQUEST['toLimit']) ? $_REQUEST['toLimit'] : 300;
		$sql = "SELECT * FROM fbUsers WHERE sessionId is not null AND `current`=1 AND appId='$appapikey' " . ($allUsers ? "":"AND id='$user'") . " Limit $iLimit, $iStopLimit";
		trace( $sql . '<br />Time Started: ');
		$conn = dbConnect();
		$results = mysql_query($sql, $conn);
		$i=0; $actualPosts=0;
		?><h1><a href="?limit=<?=$iLimit+$iStopLimit?>">Next -></a></h1><?
		flush();
		while($rs = mysql_fetch_assoc($results))
		{
			$facebook->user = $rs['id'];
			$facebook->api_client->session_key = $rs['sessionId'];
			try{
				generateAndPublishFeed($rs);
				$i++;
				echo "<h4>Checked user $rs[id] number $i</h4>";
			}catch(FacebookRestClientException $e){
				
				if($e->getCode() == FacebookAPIErrorCodes::API_EC_PARAM_SESSION_KEY)
				{
					mysql_query("UPDATE fbUsers SET sessionId=NULL WHERE appId='$appapikey' AND id='$facebook->user'", $conn);
					print_r_debug(mysql_error($conn));
					print_r_debug('Deleting sessionID');
				}else{
					print_r($e);
				}
			}

			if($i % 20 == 0){ob_flush();flush();}
		}
		$facebook->api_client->feed_deactivateTemplateBundleByID($templateBundleId);
		?><h1><a href="?limit=<?=$iLimit+$iStopLimit?>">Next -></a></h1>
        <? if($i > 1){ ?>
		<script language="javascript">
			window.location = "?limit=<?=$iLimit+$iStopLimit?>";
		</script>
		<? }
		
function generateAndPublishFeed($rs)
{
	global 	$facebook, $title, $message, $messageHTML, $cDatesStr, $actualPosts, $activeDateStr,
			$templateBundleId, $picture, $pLink;
	$id = $rs['id'];
	if(!$rs['sendEmail'] && !$rs['sendNotification'])return;
	$facebook->api_client->batch_queue = null;
	$fql = "SELECT uid, name, sex FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = $id) AND birthday in ('$cDatesStr')";
	$themStr = 'them';
	trace('Pre Query: ');
	$friends = $facebook->api_client->fql_query($fql);
	trace('Pre Loop: ');
	print_r($friends);
	if(is_array($friends) && count($friends) > 0)
	{
		echo '<h6>Actual posts: ' . $actualPosts++ .'</h6>';
		$facebook->api_client->begin_batch();
		foreach($friends as $friend)
		{
			$message2 = sprintf($message, $activeDateStr, $friend['name'], ($friend['sex']=='' ? 'them' : ($friend['sex']=='male' ? 'him' : 'her') ), $friend['uid']);
			//echo $message2;
			$messageHTML2 = sprintf($messageHTML, $activeDateStr, $friend['name'], ($friend['sex']=='' ? 'them' : ($friend['sex']=='male' ? 'him' : 'her') ), $friend['uid']);
			//echo $messageHTML2;
			if($rs['sendNotification'])
				$facebook->api_client->notifications_send_announce($facebook->user, $messageHTML2);
			if($rs['sendEmail'])
				$facebook->api_client->notifications_sendEmail($facebook->user, $title, $message2, $messageHTML2 );
		}
		if($rs['sendMiniFeed']==1 && count($friends) > 0)
		{
			$messageData = json_encode(array(	"today" => $activeDateStr, "ammount" => count($friends),
												"images" => array(array ("src" => $picture, "href" => $pLink))));
			$facebook->api_client->feed_publishUserAction($templateBundleId, $messageData);
			print_r_debug($messageData);
		}
		$facebook->api_client->end_batch();
	}
}

function trace($str)
{
	echo '<h6>'. $str . ' - ' . date("h:i:s",time()) . "</h6>\n";
}
?>
Success, sent to <?=$i?> users

<?php
error_reporting(E_ALL);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
require_once 'appinclude.php';
require_once 'jDateFunctions.php';
echo "started";
flush();

	$conn = dbConnect();
	$sql = "SELECT BornAtNight, Birthday, style, displayCurrent, displayLink FROM fbJewishDates WHERE uid='$user'";
	$results = mysql_query($sql,$conn);
	if((!$rs = mysql_fetch_assoc($results)) || $facebook->api_client->profile_getFBML($user) == "")
	{
		//addBirthdayRecord();
		//$results = mysql_query($sql);
		//$rs = mysql_fetch_assoc($results);
		
		mysql_close();
		$facebook->redirect('settings.php');
	}
	mysql_close();
?>
      <style type="text/css">
		<? require_once '../main.css'; ?>
	  </style>
      <style type="text/css">
		.options {
			margin:auto;
			width:700px;
		}
		.option {
			width: 100px;
			text-align:center;
			float:left;
			margin: 5px;
		}
		
		.boldMessage {
			border: 1px solid #3b5998 ;
			background: #eefaff ;
			width: 440px;
			float:left;
			padding: 5px 5px 5px 5px;
			margin: 3px 3px 3px 3px;
		}
		#currentDisplay {
			border: 1px solid #3b5998 ;
			margin-left: 10px;
			width:150px;
			float:left;
			padding: 5px 5px 5px 5px;
			margin: 3px 3px 3px 3px;
		}
		#upcomingList, #extendedPermissions {
			border: 1px solid #3b5998 ;
			clear:both;
			padding: 5px 5px 5px 5px;
			margin: 3px 3px 3px 3px;
		}
      </style>
	  <? require_once 'inc/header.php'; ?>
<div class="everything" style="clear:both;">
    <div class="options">
        <div class="option">
            <a href="#">
            <img src="<?=$appcallbackurl?>images/home43.gif" alt="Home" /><br />
          Home</a>
        </div>
        <div class="option">
          <a href="friends.php"><img src="<?=$appcallbackurl?>images/friends43.gif" alt="Your Friends Hebrew Birthdays" /><br />
          Your Friends Hebrew Birthdays</a>
        </div>
        <div class="option">
          <a href="settings.php"><img src="<?=$appcallbackurl?>images/account_settings43.gif" alt="Your Settings" /><br />
        Your Settings</a>        </div>
        <div class="option">
            <a href="changeBirthday.php"><img src="<?=$appcallbackurl?>images/BirthdayCake43.gif" alt="Change Your Birthday" /><br />
                Change Your Birthday
            </a>
        </div>
        <div class="option">
            <a href="messageSettings.php"><img src="<?=$appcallbackurl?>images/Email43.png" alt="Change Your Birthday" /><br />
                Notification Settings
            </a>
        </div>
        <div class="option">
            <a href="moreDates/"><img src="<?=$appcallbackurl?>images/favorites_add.png" alt="Add more dates" /><br />
                Add More Dates ($1 each)
            </a>
        </div>
	</div>
    <div id="extendedPermissions">
                <fb:add-section-button section="profile" /> <fb:add-section-button section="info" />
	</div>
	<div class="boldMessage">
    	Your Birthday is <b><?=date("M d, Y", strtotime($rs['Birthday']))?></b> (<a href="changeBirthday.php">change</a>).<br />
    	You were born <b><? if($rs['BornAtNight']){ ?>at night <? } else { ?>durring the day <? } ?></b><br />
        Your profile is displaying your <b>hebrew birthday</b>,
        <? if($rs['displayCurrent']){ ?><b> todays date </b><? } ?>
        <? if($rs['displayLink']){ ?>and <b>a link</b> to an explanation about Jewish Birthdays. <? } ?>
        (<a href="settings.php">change</a>).<br />
        Your profile is using style <b>#<?=$rs['style']?></b>(<a href="settings.php">change</a>).<br />
        Methods of receiving notifications about your friends birthdays: <a href="messageSettings.php"><b>none</b></a>. <br /><br />
    </div>
    <div id="currentDisplay"><?=printJewishBirthday($rs['Birthday'], $rs['BornAtNight'], $rs['style'], $rs['displayCurrent'], $rs['displayLink'])?></div>
	<div id="upcomingList">
    	<b><u>Your friends with birthdays in the coming week:</u></b>
        <table>
            <tr><th>Name</th><th>Hebrew Birthday</th><th>Next Occurance</th></tr>
        <? 
            $birthdays = getFriendsBirthdays();
            foreach($birthdays as $friend)
            {
				if(strtotime($friend["dateThisYear"]) > strtotime('+1 week') ) break;
                ?><tr>
                	<td  width='200'>
                    	<a href="birthdayInfo.php?id=<?=$friend["uid"]?>">
                    	<fb:name uid='<?=$friend["uid"]?>' capitalize='true' shownetwork='true' />
                        </a>
					</td>
                    <td><?=$friend["hebBirthday"]?></td><td><?=$friend["dateThisYear"]?></td>
                </tr><?
            }
        ?>
        </table>
    	<b><u>Your friends special dates in the coming week:</u></b>
        <table>
            <tr><th>Name</th><th>Event</th><th>Hebrew Date</th><th>Next Occurance</th></tr>
        <? 
			$friendlist = $_REQUEST['fb_sig_friends'];
            $specialDays = DateRecord::findByWhere('DateRecord',"uid in($friendlist)");
            foreach($specialDays as $friend)
            {
				if(strtotime($friend->getNextOccurance()) > strtotime('+1 week') ) break;
                ?><tr>
                	<td  width='200'>
                    	<a href="moreDates/?action=index&uid=<?=$friend->data["uid"]?>">
                    	<fb:name uid='<?=$friend->data["uid"]?>' capitalize='true' shownetwork='true' />
                        </a>
					</td>
                    <td><?=$friend->getHebrewDate('longeng')?></td><td><?=$friend->data['title']?><td><?=$friend->getNextOccurance()?></td>
                </tr><?
            }
        ?>
        </table>
    </div>
		<? require 'invite.php'; ?>
</div>
<fb:google-analytics uacct="UA-2420747-2" />
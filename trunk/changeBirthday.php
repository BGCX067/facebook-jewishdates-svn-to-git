<?php
error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
require_once 'appinclude.php';
require_once 'jDateFunctions.php';
?>
      <style>
		<? require_once '../main.css'; ?>
      </style>

<?
	dbConnect();
	/*
	$sql="SELECT count(*) FROM `fbInvited` WHERE appid='$facebook->api_key' AND inviter='$user'";
	$results = mysql_query($sql) or die("You must un-install and re-install this app");
	$rs = mysql_fetch_assoc($results);
	//echo $rs['count(*)'];
	if($rs['count(*)'] < 40) die('<fb:error><fb:message>You must invite 40 friends before you can use this feature.<br /><a href="./invite">Click here to invite your friends</a></fb:message></fb:error>');
	*/
	$success = 0;
	if(isset($_POST["Submit"]))
	{
		if($_POST["Submit"] == "Submit")
		{
			$Birthday = date('Y-m-d',strtotime($_POST["Birthday"]));
			$sql = "UPDATE fbJewishDates SET Birthday='$Birthday' WHERE uid=$user";
			//echo $sql;
			mysql_query($sql) or die("You must un-install and re-install this app");
			$success = 1;
		}elseif($_POST["Submit"] == "Reset"){
			$userInfo = $facebook->api_client->fql_query("SELECT birthday FROM user WHERE uid=$user");
			$Birthday = date('Y-m-d',strtotime($userInfo[0]['birthday']));
			$sql = "UPDATE fbJewishDates SET Birthday='$Birthday' WHERE uid=$user";
			mysql_query($sql) or die("You must un-install and re-install this app");
			$success = 2;
		}
	}
	$results = mysql_query("SELECT BornAtNight, Birthday, style, displayCurrent, displayLink FROM fbJewishDates WHERE uid=$user");
	if(!$rs = mysql_fetch_assoc($results)) die("<h1 style='margin:30px 30px 30px 30px;'>You have the Alpha 1.0 version of this app installed on your profile. <br /> You must un-install and re-install this app!</h1>");
	$bBornAfterSunset = $rs['BornAtNight'];
	$profileDesign = $rs['style'];
	$displayCurrent = $rs['displayCurrent'];
	$displayLink = $rs['displayLink'];
	$Birthday = date("M d, Y",strtotime($rs['Birthday']));
	mysql_close();

	$fbml = printJewishBirthday(
				$Birthday, $bBornAfterSunset,
				$profileDesign, $displayCurrent, $displayLink);
	$facebook->api_client->profile_setFBML($fbml);
	
?>
 <? include_once('inc/header.php'); ?>
<div class="everything" style="clear:both;">
<div class="wide">
    <?	if($success!=0){ ?>
            <fb:success>
                <fb:message>You have
                	<? if($success==1){ ?>
                    	changed your birthday in our system.
                    <? }elseif($success!=0){ ?>
                    	reset your birthday in our system to the date entered in your profile settings.
                    <? } ?>
                    </fb:message>
                You can now invite your friends to add "Jewish Dates" to their profile.
            </fb:success>
            <?=$fbml?>
            <div class="section">
                <h3>Invite Your Friends</h3>
                <h4>Don't they deserve the "Jewish Dates"?</h4>
                <?
                include('invite.php');   
                ?>
            </div>
    <? } ?>
	<form name="form1" method="post" action="">
    <div class="section">
    	<h3>Change Your Birthday</h3>
        <label for="Birthday">When do you think you were born?</label> 
	    <input type="text" name="Birthday" value="<?=$Birthday?>" id="Birthday" /><br />
        <small>Please enter the Gregorian date. <br />If you are trying to change Hebrew date because you don't trust our calculations, then you can just trick our system by entering the gregorian date that will make it display your correct hebrew birthday!</small>
      <hr style="clear:both;" />
    </div>      
      <input type="submit" name="Submit" value="Submit" />
      <input type="submit" name="Submit" value="Reset" />
  </form>
</div>
    
<div class="narrow">
    <div class="section">
        <h3>Resources</h3>
        <ul>
            <li><b><a href="invite.php">Invite your friends</a></b></li>
            <li><a href="http://newpaltz.facebook.com/apps/application.php?id=2518166889">About Us</a></li>
            <li><a href="http://www.chabad.org">Chabad.org</a></li>
            <li><a href="http://www.chabad.edu">Chabad on Campus</a></li>
            <li><a href="http://www.JewPaltz.com">Chabad of New Paltz</a></li>
        </ul>
    </div>
    <div class="section">
        <h3>Statistics</h3>
        <fb:success>
        	<fb:message><?=howManyUsers()?> people have Jewish Dates displayed on their profiles</fb:message>
            Now that facebook took this functionality out of the About Us page, we will be providing it ourselves.
        </fb:success>
	</div>

</div>
</div>
<fb:google-analytics uacct="UA-2420747-2" />

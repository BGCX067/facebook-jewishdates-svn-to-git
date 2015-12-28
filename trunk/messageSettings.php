<?php
//error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
$debug=false;
require_once 'appinclude.php';

	$conn = dbConnect();
	if(isset($_REQUEST['submit']))
	{
			$strNotifications = isset($_REQUEST["chkNotifications"]) ? 'true' : 'false';
			$strEmail = isset($_REQUEST["chkEmail"]) ? 'true' : 'false';
			$strMiniFeed = isset($_REQUEST["chkMiniFeed"]) ? 'true' : 'false';
			$sql = "UPDATE fbUsers SET sendNotification=$strNotifications, sendEmail=$strEmail, sendMiniFeed=$strMiniFeed WHERE id='$facebook->user' AND appid='$facebook->api_key'";
			print_r_debug($sql);
			mysql_query($sql, $conn);
			//$success = true;
			$facebook->redirect('fullPageAd.php?msg=settingssaved&settingschanged=email');
	}
	$sql = "SELECT sendNotification, sendEmail, sendMiniFeed FROM fbUsers WHERE id='$facebook->user' AND appid='$facebook->api_key'";
	print_r_debug($sql);
	$result = mysql_query($sql, $conn);
	$rs = mysql_fetch_assoc($result);
	mysql_close($conn);
?>
      <style>
		<? require_once '../main.css'; ?>
		form {
			padding: 20px 20px 20px 20px;
			font-size:14px;
			border-left:1px #000099 solid; 
			border-right:1px #000099 solid; 
		}
		#form h3 {
			background:url(<?=$appcallbackurl?>images/dialogTitleBG.jpg);
			padding:20px 20px 20px 20px;
			color:#FFFFFF;
			font-size:18px;
		}
		#form h4 {
			padding-bottom:15px;
			font-style:italic;
		}
		.formRow {
			padding:10px 10px 10px 10px;	
			clear:both;	
		}
		label {
			display:block;
			width:200px;
			float:left;
			text-align:right;
		}
		.inputSpan {
			display:block;
			width:150px;
			float:left;
		}
		.dialogBottom {
			background:url(<?=$appcallbackurl?>images/dialogBottomBorderRound.jpg);
			height:19px;
		}
      </style>
	  <? require_once 'inc/header.php'; ?>
	<div id="form">
        <h3>Message Settings</h3>
        <form promptpermission="offline_access">
            <h4>How should we notify you about your friends Jewish Birthdays?</h4>
        	<div class="formRow">
        	<label for="chkNotifications">Facebook Notifications:</label>
            <span class="inputSpan">
            	<input type="checkbox" name="chkNotifications" id="chkNotifications"
                		<? if($rs['sendNotification']){ ?>checked="checked"<? } ?>
				/>
            </span>
            </div>
            <div class="formRow">
        	<label for="chkEmail">Email:</label>
            <span class="inputSpan">
            	<input type="checkbox" name="chkEmail" id="chkEmail"
                		<? if($rs['sendEmail']){ ?>checked="checked"<? } ?>
				/>
            </span>
            </div>
            <div class="formRow">
        	<label for="chkMiniFeed">My Minifeed:</label>
            <span class="inputSpan">
            	<input type="checkbox" name="chkMiniFeed" id="chkMiniFeed"
                		<? if($rs['sendMiniFeed']){ ?>checked="checked"<? } ?>
				/>
            </span>
            </div>
            <div class="formRow" align="right" >
            	<input type="submit" name="submit" value="Submit"class="inputbutton"/>
			</div>
        </form>
        <div class="dialogBottom"></div>
    </div>
    <fb:google-analytics uacct="UA-2420747-2" />

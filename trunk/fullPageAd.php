<?php
error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
require_once 'appinclude.php';
require_once 'jDateFunctions.php';

include_once 'inc/header.php';
	$bBornAfterSunset = NULL; $profileDesign = NULL; $displayCurrent = NULL; $displayLink = NULL; $birthday = NULL;
	$success = false;
	updateJDateProfile();

?>
	<? switch($_REQUEST['msg']){
    	case 'randompage': ?>
            <fb:success>
                <fb:message>You have arived at a random page in the 'Jewish Dates' application.</fb:message>
                If you are trying to upgrade your profile with 'Jewish Dates' you have been succesful.
                You can now go on your merry way. <br />
                If you have come here to change your settings, prefrences or registered birthday or would like to find the Hewbrew birthdays of your friends
                please visit the <a href="./">Application home page</a>.
            </fb:success>
        <?	break;
		case 'profile':?>
            <fb:success>
                <fb:message>You have updated the abbilities of your profile box. It can now be put on your main tabs.</fb:message>
                If you see the permissions button below, click it and choose "Wall Tab".
				If the button does not appear, go to your <a href="http://www.new.facebook.com/profile.php?v=box_3">boxes tab</a> and click the little pencil on top of "Jewish Dates"
				<fb:add-section-button section="profile" />
            </fb:success>
        <?	break;
		case 'settingssaved':?>
                <fb:success>
                    <fb:message>Your settings have been updated</fb:message>
                    Thank you for using the Jewish Dates <br />
                    <? if(isset($_REQUEST['settingschanged']) && $_REQUEST['settingschanged']=='email') { ?>
                    <fb:prompt-permission perms="email">If see this then you need to click it before we can send you emails</fb:prompt-permission>
                    <? } ?>
                </fb:success>
        <?	break;
		case 'info':?>
            <fb:success>
                <fb:message>Jewish Dates is now ready to be integrated directly into your profile.</fb:message>
                Just click the button bellow, and give permission. It will show you exacly how it will look, before you approve it.<br />
				You will need to click one of these for each of the new features.<br />
				Its facebook's way of making sure you have full control over how you are represented.
                <fb:add-section-button section="info" />
            </fb:success>
		<?	break;
    	case 'sharing':
        default: ?>
            <fb:success>
                <fb:message>Thanks for sharing 'Jewish Dates' with your friends.</fb:message>
                You can either return to the <a href="./">Application home page</a> or invite more friends below.
            </fb:success>
    <? } ?>
<div style="margin:auto; width:630px">
<fb:iframe src="<?=$appcallbackurl?>amazonOmakase300x250.php" border="0" width="300" height="250" resizable="false" name="socialmedia_ad" scrolling="no" frameborder="0"></fb:iframe>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?=$appcallbackurl?>../redirect.php?uid=<?=$user?>&from=JewishDates&to=jwed2">
	<img src="<?=$appcallbackurl?>images/jwed2.jpg" style="border:#0099FF 1px solid"/>
</a>
<br /><br />
<a href="<?=$appcallbackurl?>../redirect.php?uid=<?=$user?>&from=JewishDates&to=jwed2">
	<img src="<?=$appcallbackurl?>images/jwed3.jpg" style="border:#0099FF 1px solid"/>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<fb:iframe src="http://ads.socialmedia.com/facebook/monetize.php?width=300&height=250&pubid=01b13f1f6554364ebaf635a5f4bedae2" border="0" width="300" height="250" resizable="false" name="socialmedia_ad" scrolling="no" frameborder="1"></fb:iframe>
</div>

<fb:google-analytics uacct="UA-2420747-2" />

<?php
//error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
require_once 'appinclude.php';
?>
      <style>
		<? require_once '../main.css'; ?>
      	.profileDesign{
			float:left;
			border: 1px solid #0099FF;
			width:180px;
			margin:5px 5px 5px 5px;
		}
		.profileDesign:hover{
			background-color: #CCEEFF;
		}
      </style>
<?
	//	public variables
	$bBornAfterSunset = NULL; $profileDesign = NULL; $displayCurrent = NULL; $displayLink = NULL; $birthday = NULL;
	$success = false;
	updateJDateProfile();
?>
<!--
<div style="float:left; width:280px; padding:10px 10px 10px 10px; text-align:center;">
<A href="http://www.a-zara.com/index.asp?af=mplotkin&bn=73"><img src="http://www.a-zara.com/affiliate/Banners/general-234-60.gif" width=234 height=60 border=0 alt="ZaraMart"></A>
</div>
<div style="float:left; width:315px;">
<fb:success>
    <fb:message><a href="http://apps.facebook.com/jewishdates/supportChabadOfNewPaltz.php">Support Chabad of New Paltz.</a></fb:message>
	 If you help me, I will continue to help you.
</fb:success>
</div> -->
<!--<div style="float:left; width:330px;">
<fb:success>
    <fb:message><a href="http://db2602c2.fb.joyent.us/jwedweb/track_camp.php?campid=4">
    	ONE person on Jwed married EVERY day!
    </a></fb:message>
	Jewish Dating for Marriage with the <a href="http://db2602c2.fb.joyent.us/jwedweb/track_camp.php?campid=4">Jwed application.</a>
</fb:success>
</div>-->
	  <? require_once 'inc/header.php'; ?>

<? if(!preg_match("/[a-zA-Z]+\s\d{2},\s\d{4}/", $birthday)) { ?>
	<fb:error>
		<fb:message>
		You are hiding (part of) your birthday</fb:message>
		You have told facebook not to display your entire birthday. As such, this application thinks your birthday is <b><?=$birthday?></b>.
		Please reveal your birthday in your profile <a href="../editprofile.php">by clicking here</a> and then return to this page.
		<p>Or <a href="changeBirthday.php">enter an alternate date here</a>.</p>
	 </fb:error>
<? 	} ?>
<div class="everything" style="clear:both;">
                <fb:add-section-button section="profile" /> <fb:add-section-button section="info" />

<div class="wide">
    <?	if($success){ ?>
            <fb:success>
                <fb:message>You have successfully updated your profile.</fb:message>
                However, you might still need to click on the button above, to allow this program to display on your profile.<br />
                Also remember, you can invite your friends to add "Jewish Dates" to their profile.
            </fb:success>
            <div class="section">
                <h3>Invite Your Friends</h3>
                <h4>Don't they deserve the "Jewish Dates"?</h4>
                <?
				require 'invite.php';
                ?>
            </div>
    <? } ?>
    <div class="section">
		This application will automatically convert your birthday from the secular calendar to the Hebrew calendar.
        <br />
        This application thinks your birthday is <?=$userInfo[0]['birthday']?> (<a href="changeBirthday.php">change</a>)
    </div>
	<form name="form1" method="post" action="" promptpermission="offline_access" >
    <div class="section">
    	<h3>Birthday Options</h3>
      	<label for="chkSunset">Were you born after sunset?</label> 
	  	(<a href="http://www.chabad.org/calendar/birthday.asp" target="_blank">I don't know</a>)
	    <input type="checkbox" name="chkSunset" value="on" id="chkSunset" <? if($bBornAfterSunset){ ?> checked="checked"<? } ?> />
    </div>
    <div class="section">
    	<h3>Formatting Options</h3>
        <h4>Choose a design:</h4>
      	
      	<label for="pd1"><div class="profileDesign"><div>
       	  <div align="center">
          	<input type="radio" name="profileDesign" id="pd1" value="1" <? if($profileDesign==1)echo "checked"; ?> />
		  </div>
            <? echo printJewishBirthday($birthday, $bBornAfterSunset, 1, $displayCurrent, $displayLink); ?>
          </div>
      	 </div></label>
        
        <label for="pd2"><div class="profileDesign">
       	  <div align="center">
          	<input type="radio" name="profileDesign" id="pd2" value="2" <? if($profileDesign==2)echo "checked"; ?> />
            <br />
            <? echo printJewishBirthday($birthday, $bBornAfterSunset, 2, $displayCurrent, $displayLink); ?>
            <br />
            <br />
        </div>
           </div></label>
      	

        <label for="pd3"><div class="profileDesign"><div>
       	  <div align="center">
          	<input type="radio" name="profileDesign" id="pd3" value="3" <? if($profileDesign==3)echo "checked"; ?> />
          </div>
            <? echo printJewishBirthday($birthday, $bBornAfterSunset, 3, $displayCurrent, $displayLink); ?>
          </div></div>
        </label>

        <label for="pd4"><div class="profileDesign">
       	  <div align="center">
          	<input type="radio" name="profileDesign" id="pd4" value="4" <? if($profileDesign==4)echo "checked"; ?> />
            <br />
              <? echo printJewishBirthday($birthday, $bBornAfterSunset, 4, $displayCurrent, $displayLink); ?>
              <br />    
              <br />
            </div>
        </div>
      	</label>
		<br clear="all" />
      </div>
      <br clear="all" />
    <div class="section">
        <h3>More Options</h3>
        	<input type="checkbox" name="chkToday" <? if($displayCurrent){ ?>checked="checked"<? } ?> />
            <label for="chkToday">Display the current Date</label><br />
        	<input type="checkbox" name="chkExplanation" <? if($displayLink){ ?>checked="checked"<? } ?> />
            <label for="chkToday">Display a link to an Explanation</label><br />
	</div>
      
      <hr style="clear:both;" />
      <input type="submit" name="Submit" value="Submit" />
  </form>
    <?	if(!$success){ ?>    
            <div class="section">
                <h3>Invite Your Friends</h3>
                <h4>Don't they deserve the "Jewish Dates"?</h4>
                <?
				require 'invite.php';
                //$inv->show($user, $inviteMsg, $inviteImg);   
                ?>
            </div>
    <?	} ?>
</div>
    
<div class="narrow">
    <div class="section">
      <fb:iframe	src="<?=$appcallbackurl?>amazonwidget.php" width="120" height="400"
      				frameborder="0" scrolling="no" style="float:right" /> 
    </div>
    <div class="section">
    <!--
        <h3>News</h3>
        New Feature! Feeds are posted to your homepage about your friends Jewish Birthdays (whether they installed this program or not) and upcoming special days on the Jewish Calendar.
        <hr />
        Sound off About the new design
            <a href="http://newpaltz.facebook.com/edittopic.php?uid=2518166889&topic=2914&action=4&reply_to=10665&pwstdfy=125309c51da5ad247fc070921947a8c2">
            	By Clicking Here
            </a>
            <hr />
        New Feature! Change your birthday. <br />
        If you do not want your birthday displayed in facebook but you do want your hebrew birthday displayed, or if the birthday in your facebook profile returns the wrong hebrew date.
            <br />
            Edit the date that this application uses to calculate your Hebrew birthday <a href="changeBirthday">by clicking here</a>.
        <hr />
        New "Friends' Hebrew Birthdays" function added. <br />
        Click on the link at the top of the page to view the Jewish Birthdays of your friends, whether they added this app or not.
        <hr />
        Fixed the missing "Next Occurrence" bug!
        <hr />
        The extra options added last week are now much more robust!
     -->
	</div>

</div>
</div>
<fb:google-analytics uacct="UA-2420747-2" />

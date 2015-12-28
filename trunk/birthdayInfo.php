<?php
//error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
$debug=false;
require_once 'appinclude.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $user;

		$userInfo = $facebook->api_client->fql_query("SELECT birthday FROM user WHERE uid=$id");
		$birthday = $userInfo[0]['birthday'];
		$ahebdate = explode("/", strGregToHeb($birthday, false));
?>
      <style>
		<? require_once '../main.css'; ?>
		form {
			border-left:1px #000099 solid; 
			border-right:1px #000099 solid; 
			overflow:hidden;
		}
		#form h3 {
			background:url(<?=$appcallbackurl?>images/dialogTitleBG.jpg);
			padding:20px 20px 20px 20px;
			color:#FFFFFF;
			font-size:18px;
		}
		.dialogBottom {
			background:url(<?=$appcallbackurl?>images/dialogBottomBorderRound.jpg);
			height:19px;
		}
		h4 {
			color:#999999;
			font-weight:bold;
			clear:both;
			margin-top: 20px;
		}
		.theInfo {
			width:299px;
			float:left;
			padding:10px 10px 10px 10px;	
		}
		.row {
			padding:5px 5px 5px 5px;	
			clear:both;	
		}
		label {
			display:block;
			width:100px;
			float:left;
			text-align:right;
		}
		.value {
			display:block;
			width:150px;
			float:left;
			margin-left:10px;
		}
	  </style>
	  <? require_once 'inc/header.php'; ?>
      <fb:iframe	src="<?=$appcallbackurl?>amazonwidget.php" width="120" height="400"
      				frameborder="0" scrolling="no" style="float:right" /> 
	<div id="form">
      <h3><fb:name uid="<?=$id?>" linked="false"  /></h3>
      <form>
      <fb:profile-pic uid="<?=$id?>" size="normal" linked="true" style="float:left" />
      <div class="theInfo">
      	<fb:if-can-see uid="<?=$id?>" what="profile">
          <h4>Birthday Info:</h4>
          <div class="row">
          	<label>Jewish Birthday:</label>
            <span class="value"><?=strGregToHeb($birthday,true)?> - <?=strGregToHeb($birthday,false)?></span>
          </div>
          <div class="row">
          	<label>Next Occurance:</label>
            <span class="value"><?=dateThisYear($ahebdate)?></span>
          </div>
          <h4>Actions:</h4>
          <div class="row">
            <b><a href="http://www.facebook.com/inbox/?compose&id=<?=$id?>" target="_blank" >
                Send
                <fb:name uid="<?=$_REQUEST['id']?>" capitalize="true" linked="false" firstnameonly="true" />
                a Message
            </a></b>
          </div>
          <div class="row">
            <b><a href='http://www.facebook.com/profile.php?id=<?=$id?>' target="_blank">
                Post on
                <fb:name uid="<?=$id?>" capitalize="true" linked="false" firstnameonly="true" possessive="true" />
                wall
            </a></b>
          </div>
          <div class="row">
            <b><a href='http://www.judaism.com/index.asp?aref=mplotkin' target="_blank">
                Buy
                <fb:name uid="<?=$id?>" capitalize="true" linked="false" firstnameonly="true"/>
                a jewish present at Judaism.com
            </a></b>
          </div>
          <div class="row">
            <b><a href="http://www.amazon.com/gp/search?ie=UTF8&keywords=&tag=jewdatfacapp-20&index=blended&linkCode=ur2&camp=1789&creative=9325">
                Buy
                <fb:name uid="<?=$id?>" capitalize="true" linked="false" firstnameonly="true"/>
                a regular gift.
            </a></b>
                <img src="http://www.assoc-amazon.com/e/ir?t=jewdatfacapp-20&amp;l=ur2&amp;o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
          </div>

		</div>
          
          <fb:else>Sorry, only for friends and people in the network.</fb:else>
        </fb:if-can-see> 
      </div>
      </form>
      <div class="dialogBottom"></div>
    </div>
    <fb:google-analytics uacct="UA-2420747-2" />

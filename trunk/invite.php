<?php
error_reporting(0);
require_once 'appinclude.php';
$invfbml = <<<FBML
	<fb:name uid="$user" shownetwork="false"/>
	thought you would like to express your jewish pride by putting Your Jewish Birthday on your Facebook profile.
	<fb:req-choice url="http://apps.facebook.com/jewishdates/" label="Add Jewish Dates!" />
FBML;

?>
      <style type="text/css">
		<? require_once '../main.css'; ?>
	  </style>
	  <? require_once 'inc/header.php'; ?>
<fb:fbml>
<? 	if(isset($_REQUEST['done'])) 
	{
		updateInvitedList($user);
		$facebook->redirect('fullPageAd.php');
	} ?>
<fb:request-form action="invite.php?1=1&done=1" method="POST" type="Jewish Dates" content="<?=htmlentities($invfbml)?>" invite="true">

<fb:multi-friend-selector 
showborder="true" 
actiontext="Spread the word! Share 'Jewish Dates' with your friends!" exclude_ids="<?=getInstalledAndInvitedFriends($user)?>"/>

</fb:request-form>
</fb:fbml>
<fb:google-analytics uacct="UA-2420747-2" />

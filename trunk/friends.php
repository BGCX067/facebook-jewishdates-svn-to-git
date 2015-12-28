<?php
error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
require_once 'appinclude.php';
require_once 'jDateFunctions.php';

include_once 'inc/header.php';
?>

<div style="padding:10px 10px 10px 10px;">
<p>Know the Jewish Birthdays of your friends, whether they added this app or not.</p>
      <fb:iframe	src="<?=$appcallbackurl?>amazonwidget.php" width="120" height="400"
      				frameborder="0" scrolling="no" style="float:right" /> 
<table>
	<tr><th>Name</th><th>Hebrew Birthday</th><th>Next Occurance</th></tr>
<? 
	$birthdays = getFriendsBirthdays();
	foreach($birthdays as $friend)
	{
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
</div>
<fb:google-analytics uacct="UA-2420747-2" />

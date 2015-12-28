<?php
error_reporting(0);
require_once 'appinclude.php';

?>
<h1>The Admin Page</h1>
<? 
		dbConnect();
		$sql = "SELECT * FROM `fbJewishDates`";
		$results = mysql_query($sql);
		$num=mysql_numrows($results);
		$i=0;
		while($i < $num) {
			$tuid = mysql_result($results,$i++,"uid");
			?>
			<div style="float:left; text-align:center; margin:5px 5px 5px 5px; ">
				<fb:profile-pic uid='<? echo $tuid; ?> ' size='s' /><br />
				<fb:userlink uid='<? echo $tuid; ?> ' />
			</div>
			<?
		}
		mysql_close();
 ?>
 <fb:google-analytics uacct="UA-2420747-2" />

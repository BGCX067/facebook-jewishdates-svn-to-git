<a href="/jewishdates/">Jewish Dates</a> >>
<a href="/jewishdates/moreDates/actions.php?uid=<?=$user?>">Your List</a> >>
<?=$rec->data['title']?>
<br /><br />
<?		if(isset($rec)){		?>
	<h1><?=$rec->data['title']?></h1>
	<b>Original Date:</b><?=$rec->data['originalDate']?><br />
	<b>Hebrew Date:</b><?=$rec->getHebrewDate('longeng')?> - <?=$rec->getHebrewDate('shortheb')?><br />
	<b>Next Occurance:</b><?=$rec->getNextOccurance()?><br />
<? 		}else{ 					?>
	<h1>Sorry the page you requested does not exist</h1>
<?		}						?>
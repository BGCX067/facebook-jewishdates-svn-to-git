<style>
	#content, #content h1, #content table{
		font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-size: larger;
	}
	th { font-size: 12px;}
	td { padding: 3px 3px 3px 3px;}
	.rowa {
	    background-color: #fff;
	    border: 1px solid #fff;
	    margin: 26px;
	    padding: 15px;
	}
	.rowb {
	    background-color: #ccc;
	    border: 1px solid #ccc;
	    margin: 26px;
	    padding: 15px;
	}
</style>
<div id="content">
<div align="center">
	<fb:add-section-button section="profile" /> <fb:add-section-button section="info" />
	<fb:prompt-permission perms="email">Click Here to allow us to send you Email</fb:prompt-permission>
</div>
<a href="/jewishdates/">Jewish Dates</a> >>
<a href="/jewishdates/moreDates/actions.php?uid=<?=$user?>">
	<fb:name uid="<?=$user?>" possessive="true" capitalize="true" linked="false"/> List
</a>
<br /><br />
	<? showInsertMessage($insertedRecord); ?>
<h1><fb:name uid="<?=$user?>" possessive="true" capitalize="true" /> Important Dates</h1>
<a href='?action=new'>Create New</a>

		<table>
			<thead>
				<tr>
					<th>Title</th><th>Original Date</th><th>Hebrew Date</th><th>Next Occurance</th>
				</tr>
			</thead>
<?
	foreach($records as $rec)
	{
		$css_class = ($css_class == 'rowa') ? 'rowb' : 'rowa';
		?>
			<tr class="<?=$css_class?>">
				<td><b> <?=$rec->data['title']?></b></td>
				<td><?=$rec->getOriginalDate()?></td>
				<td><?=$rec->getHebrewDate('longeng')?></td>
				<td><?=$rec->getNextOccurance()?></td>
				<td style="text-align:right">
					<a href='?action=show&id=<?=$rec->data['id']?>'>Show</a> |
					<a href='?action=edit&id=<?=$rec->data['id']?>'>Edit</a> |
					<a href='?action=delete&id=<?=$rec->data['id']?>'>Delete</a>		
				</td>
			</tr>
		
		<?
	}
?>
		</table>
</div>
<?
function showInsertMessage($insertedRecord)
{
	if(isset($insertedRecord))
	{
		?>
		<fb:success>
			<fb:message>"<?=$insertedRecord->data['title'] ?>" has been entered.</fb:message>
			<ul>
				<li><p>A message has been posted to your wall.</p></li>
				<li><p>Every year on <?=$insertedRecord->getHebrewDate('medeng')?> a message will be posted to your wall and hopefuly be displayed on your friends facebook home pages.</p></li>
				<li><p>Every year on <?=$insertedRecord->getHebrewDate('medeng')?> you will be sent a reminder notification about "<?=$insertedRecord->data['title'] ?>".</p></li>
				<li><p>"<?=$insertedRecord->data['title'] ?>" will be shown to your friends on their 'Jewish Dates' home page every year for one week proceeding <?=$insertedRecord->getHebrewDate('medeng')?></p></li>
				<li><p>"<?=$insertedRecord->data['title'] ?>" has been added to your profile info tab (as long as you have given this application permission to do that)</p></li>
				<li><p>"<?=$insertedRecord->data['title'] ?>" has been added to this page.</p></li>
				<li><p>"<?=$insertedRecord->data['title'] ?>" has been added to the 'Jewish Dates' box if or when it is displayed on the 'Boxes' tab.</p></li>
			</ul>
		</fb:success>
		<?
	}
}
?>
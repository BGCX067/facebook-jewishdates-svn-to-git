<?php
//error_reporting(0);
//header("Content-Type: application/xhtml+xml; charset=utf-8;");
require_once '../appinclude.php';
$sFQL = isset($_REQUEST['sFQL']) ? $_REQUEST['sFQL'] : '';
?>
<style>
	.entry {
		clear: both;
		vertical-align: top;
		
		padding: 5px 5px 5px 5px;
		border-bottom: groove;
	}
	.data {
		float: left;
		margin-left: 6px;
	}
	h5 {
		color: green;
	}
</style>
<div style="padding:10px 10px 10px 10px;">
	<a href="http://wiki.developers.facebook.com/index.php/FQL_Tables">FQL Tables</a>
    <form>
    	<label for="sFQL">Search (fql):</label>
        <textarea name="sFQL" id="sFQL" rows="4" cols="300" ><?=$sFQL?></textarea>
        <input type="submit" name="submit" value="GO" />
    </form>
    <? 
		if($sFQL != '')
		{
			$friends = $facebook->api_client->fql_query("SELECT uid, education_history, affiliations FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1=$facebook->user) AND $sFQL");
			//print_r($friends);
			?><h2>Listing <?=count($friends)?> friends</h2><?
			foreach($friends as $friend)
			{
				?>
                <div class="entry">
                	<fb:profile-pic uid='<?=$friend['uid']?>' linked='yes' size='square' network="yes" style="float:left;"  />
                	<div class="data">
						<fb:name uid='<?=$friend['uid']?>' capitalize='true' shownetwork='true' /><br />
						<h5>Education:</h5>
						<?if(is_array($friend['education_history'])) foreach($friend['education_history'] as $hi){ ?>
							<i><?=$hi['name']?></i> <b><?=$hi['year']?></b><br />
						<? } ?>
						<h5>Networks:</h5>
						<?if(is_array($friend['affiliations'])) foreach($friend['affiliations'] as $hi){ ?>
							<i><?=$hi['name']?></i> <b><?=$hi['year']?></b><br />
						<? } ?>
					</div>
					<br clear="all" />
				</div>
                <?
			}
		}else{
			echo '<h1>Please type in a search</h1>';
		}
    ?>
    </table>
</div>
<fb:google-analytics uacct="UA-2420747-2" />

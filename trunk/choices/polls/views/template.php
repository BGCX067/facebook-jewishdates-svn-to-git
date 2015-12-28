<style>
	body, table{
		font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
</style>
<script src="scripts/basicFunctions.js"></script>
<a href="actions.php">Index</a>
<?
	echo getFlashMessages();
	include "views/$action.php";
	
?>
<fb:google-analytics uacct="UA-2420747-2" />
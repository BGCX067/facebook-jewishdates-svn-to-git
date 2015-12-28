<style>
	body {
	}
	table {
		font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-size: small;
		border: blue 1px solid;
		float: left;
		margin: 5px 5px 5px 5px;
		width: 100px;
	}
	th {
		background: #0000aa;
	}
	th a {
		color: #ffffff;
		font-variant:small-caps;
	}
</style>
<?php
	require_once 'appinclude.php';
	require_once dirname(__FILE__) . '/../facebookIncludes/stats/view1.php';
	renderCrossView('religion', $_REQUEST['conditions']);
	renderCrossView('sex', $_REQUEST['conditions']);
	renderCrossView('relationship_status', $_REQUEST['conditions']);
	renderCrossView('political', $_REQUEST['conditions']);
	renderCrossView('hometown_city', $_REQUEST['conditions']);
	renderCrossView('hometown_state', $_REQUEST['conditions']);
	renderCrossView('hometown_country', $_REQUEST['conditions']);
	renderCrossView('age', $_REQUEST['conditions']);
	renderCrossView('current_city', $_REQUEST['conditions']);
	renderCrossView('current_state', $_REQUEST['conditions']);
	renderCrossView('current_country', $_REQUEST['conditions']);
?>
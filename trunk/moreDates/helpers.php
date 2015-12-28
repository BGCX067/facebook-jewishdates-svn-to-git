<?
function actionRedirect($action, $params=null)
{
	header( 'Location: http://d9744086.fb.joyent.us' . $_SERVER['SCRIPT_NAME'] . "?action=$action&$params" );
}
function getFlashMessages()
{
	if(isset($_SESSION['flash']))
	{
		$msg = $_REQUEST['flash'];
		unset($_SESSION['flash']);
		return "<fb:notice><fb:message>$msg</fb:message></fb:notice>";
	}	
}
function postAddedFeed($rs)
{
	global $facebook;
	$messageData = json_encode(array(	"title" => $rs->data['title'], "hebrewDate" => $rs->getHebrewDate('medeng'), "originalDate" => $rs->data['originalDate'], "nextOccurance" => $rs->getNextOccurance(),
										"images" => array(array ( "src" => 	'http://www2.newpaltz.edu/~plotkinm/php/facebook/jewishdates/Icon75x75.gif'
																, "href" => 'http://apps.facebook.com/jewishdates/supportChabadOfNewPaltz.php'))));
	$facebook->api_client->feed_publishUserAction(39808846889, $messageData);
}
?>

<?
function actionRedirect($action, $params=null)
{
	//header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?action=$action&$params" );
	redirect('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?action=$action&$params");
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
function redirect($url) {

			echo "<script type=\"text/javascript\">\nlocation.href = \"$url\";\n</script>";
  }
?>

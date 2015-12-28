<?
require_once '../facebookIncludes/fbUtilInclude.php';
$uid = $_REQUEST['fb_sig_user'];
$session = $_REQUEST['fb_sig_session_key'];
$appId = $_REQUEST['fb_sig_api_key'];
removeUser($appId, $uid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>We are sorry to see you go</title>
</head>

<body>
	<h1>You have succesfully removed the application</h1>
</body>
</html>
<fb:google-analytics uacct="UA-2420747-2" />

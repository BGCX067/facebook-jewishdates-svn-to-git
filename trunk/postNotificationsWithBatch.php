<?php
$noframe=true;
require_once 'appinclude.php';
$titleEmail = 'Win an iPAD and help a Jewish school for FREE';
$messageEmail1 = file_get_contents('messages/CCMonsey.html');
$messageEmail2 = file_get_contents('messages/CCMonsey.txt');

	echo $message;
	while (ob_get_level() > 0) ob_end_flush();
	flush();

$allUsers=true;
$batch=false;
$subBatchSize = 90;
$batchSize = 360;
$messageType = 3;	//	1=Notice, 2=Email, 3=Both;
$endLimit = 500;

include '../facebookIncludes/postNotificationsWithBatch.php';
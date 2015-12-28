<?
//error_reporting(0);
require_once 'appinclude.php';
require_once 'jDateFunctions.php';

registerBundleUpgrade();
function registerBundleUpgrade()
{
	global $facebook;
	$one_line_story = array('{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a> their hebrew birthday is {*hebrewBirthday*}.',
							'{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a>.');
	$short_story = array(
						array(	'template_title'   => '{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a>.',
						  		'template_body'    => 'Their hebrew birthday - {*hebrewBirthday*} - will be prominently displayed on their profile. They will be able to find their <a href="http://apps.facebook.com/jewishdates/friends.php">friends Hebrew Birthdays</a>. And they will be connected to a whole network of Jewish friends on Facebook.'),
						array(	'template_title'   => '{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a>.',
						  		'template_body'    => 'Their hebrew birthday will be prominently displayed on their profile. They will be able to find their <a href="http://apps.facebook.com/jewishdates/friends.php">friends Hebrew Birthdays</a>. And they will be connected to a whole network of Jewish friends on Facebook.')
						);
	
	$full_story = $short_story;
	echo $facebook->api_client->feed_registerTemplateBundle($one_line_story, $short_story, $full_story);
}
function registerBundleBirthdayToday()
{
	global $facebook;
	$one_line_story = array('{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a> their hebrew birthday is {*hebrewBirthday*}.',
							'{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a>.');
	$short_story = array(
						array(	'template_title'   => '{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a>.',
						  		'template_body'    => 'Their hebrew birthday - {*hebrewBirthday*} - will be prominently displayed on their profile. They will be able to find their <a href="http://apps.facebook.com/jewishdates/friends.php">friends Hebrew Birthdays</a>. And they will be connected to a whole network of Jewish friends on Facebook.'),
						array(	'template_title'   => '{*actor*} upgraded to <a href="http://apps.facebook.com/jewishdates/">Jewish Dates 3.0</a>.',
						  		'template_body'    => 'Their hebrew birthday will be prominently displayed on their profile. They will be able to find their <a href="http://apps.facebook.com/jewishdates/friends.php">friends Hebrew Birthdays</a>. And they will be connected to a whole network of Jewish friends on Facebook.')
						);
	
	$full_story = $short_story;
	echo $facebook->api_client->feed_registerTemplateBundle($one_line_story, $short_story, $full_story);
}
?>
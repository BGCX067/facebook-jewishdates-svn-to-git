<?php
$noframe=true;
require_once 'appinclude.php';

/*
$message = "We are working hard to upgrade Jewish Dates to take advantage of the new profile. The only thing you need to do is visit (any) one of the Jewish Dates pages, and your profile will be upgraded. (You may need to do this again as we add features.)";
$message = 	'Please do NOT block messages from this application. There are going to be some important upgrade instructions and without them the application will STOP WORKING properly. If you do not like these messages, please <a href="http://www.new.facebook.com/editapps.php?v=all">TOTALLY REMOVE</a> this application. Doing so will stop these messages and remove that annoying box on your profile saying "My Hebrew birthday is...". '
		. 	'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '
		.	'If you haven\'t upgraded yet, please visit <a href="http://apps.new.facebook.com/jewishdates/fullPageAd.php?msg=randompage">any random page</a> in the "Jewish Dates" application and your profile will automatically be upgraded. ';

$message =	'You can now move your Jewish Birthday information to the main tabs of your profile, where they belong. '
		.	'Just go to <a href="http://apps.new.facebook.com/jewishdates/fullPageAd.php?msg=profile">the profile update page</a>. '
		.	'If you are presented with a permissions button, click it and choose "Wall Tab". '
		.	'If the button does not appear go to your <a href="http://www.new.facebook.com/profile.php?v=box_3">boxes tab</a> and click the little pencil on top of "Jewish Dates" ';

$message = 	'It gets even better! Jewish Dates can now integrate directly into your profile. Click the link below to add a FIELD into your Info Section. At first it will display your Hebrew Birthday and then any other features we add. '
		.	'You will need to click a special "Permissions" button once you get to the "Jewish Dates" Page. It will show you how it will look before you approve it. '
		.	'(You will need to click one of these for each of the new features. '
		.	'Its facebook\'s way of making sure you have full control over how you are represented.) ';
$messageEmail1 = str_replace('.',".<br />",$message) . "<br /><a href='http://apps.new.facebook.com/jewishdates/fullPageAd.php?msg=info'>Jewish Dates 'Info Feature' Page</a>";
$messageEmail2 = str_replace('.',".\n",$message) . "\nhttp://apps.new.facebook.com/jewishdates/fullPageAd.php?msg=info";

//Notification - HTML links, no line breaks
$message = 	<<<MSG
You can now add "More Dates" to "Jewish Dates": <a href="http://apps.new.facebook.com/jewishdates/moreDates/">Right Here</a>
Just type in what is special about the date - your kids birthdays, your grandfathers Yahrtziet, or your cousin vini's anniversary, etc.
Then type in the regular (secular) date.
The application will then add the corresponding Hebrew date (plus the next time it will occur) to facebook, etc.
- I am asking everyone to send one dollar for every "Special Date" you add. This will enable me to continue bringing useful Jewish Applications to facebook and beyond.
MSG;
//HTML
$messageEmail1 = <<<MSG
	<a href="http://apps.new.facebook.com/jewishdates/moreDates/">http://apps.new.facebook.com/jewishdates/moreDates/</a>
	<p>This brand new feature allows you to add any date to your list.</p>

	<p>Just type in what is special about the date - your kids birthdays, your grandfathers Yahrtziet, or your cousin vini's anniversary, etc.<br />
	Then type in the regular (secular) date.<br />
	The application will then add the corresponding Hebrew date (plus the next time it will occur) to facebook, etc</p>
	
	<p>Once you've added the date. All your friends will be able to see it on their Jewish Dates Home Page, Your profile information tab, Your profile on the boxes tab, On your wall when this special day comes around, and in their home page feeds (if they haven't blocked stories from you ;) )</p>
	
	<p>I am asking everyone to send one dollar for every "Special Date" you add. This will enable me to continue bringing useful Jewish Applications to facebook and beyond.<br />
	$1 dollar is really not much. but if everyone gave 1 then it would add up.</p>
MSG;
 //Text
 $messageEmail2 = <<<MSG
 http://apps.new.facebook.com/jewishdates/moreDates/
 
This brand new feature allows you to add any date to your list.

Just type in what is special about the date - your kids birthdays, your grandfathers Yahrtziet, or your cousin vini's anniversary, etc.
Then type in the regular (secular) date.
The application will then add the corresponding Hebrew date plus the next time it will occur.

Once you've added the date. All your friends will be able to see it on their Jewish Dates Home Page, Your profile information tab, Your profile on the boxes tab, On your wall when this special day comes around, and in their home page feeds (if they haven't blocked stories from you ;) )

I am asking everyone to send one dollar for every "Special Date" you add. This will enable me to continue bringing useful Jewish Applications to facebook and beyond.
$1 dollar is really not much. but if everyone gave 1 then it would add up.
MSG;

$titleEmail = 'Bring a friend Shabbat at your Local Chabad House';
$message = "In response to the terror. Every Chabad House on Campus is hosting <a href='http://www.facebook.com/event.php?eid=100611180452'>Bring-A-Friend Shabbat: Filling the Void'</a>. Please visit your local Chabad House this Friday Evening and invite any college students you know to do the same <a href='http://www.MitzvotForMumbai.org/jd'>using the Mitzvot for Mumbai website</a>.";
$messageEmail2 = <<<MMM
B"H"

Last week terrorists in India killed more than 175 people. In the process they destroyed a Chabad House and killed its inhabitants. The Jewish community lost six precious souls, leaving six empty seats at the global Shabbat table. The response to such extreme darkness must be to increase light exponentially.

This week let's fill those seats -- a thousand times over! Let's make sure every Jewish student celebrates Shabbat.

Please visit you local Chabad House this Friday Evening and invite any college students you know to do the same using the website http://www.MitzvotForMumbai.org.
MMM;
$messageEmail1 = str_replace("\n",'<br>',$messageEmail2);
$message = 'The main part of this application is still FREE. However we have added some pretty cool functionality which allows you to <a href="http://apps.new.facebook.com/jewishdates/moreDates/">add more Hebrew Dates</a> to your profile for just $1 a pop. <a href="http://apps.new.facebook.com/jewishdates/moreDates/">Check it out.</a>';
$titleEmail = 'The main part of this application is still FREE.';
$messageEmail1 = <<<MMM
B"H<br><br>
However we have added some pretty cool functionality which allows you to <a href="http://apps.new.facebook.com/jewishdates/moreDates/">add more Hebrew Dates</a> to your profile for just $1 a pop.<br><br>
With this feature, you can add you kids' birthdays, your parents' birthdays, your grand parents' yahrtziets or anything else you can think of.<br><br>
You will then be notified in many ways when that Hebrew day approaches, and even your friends can see it. Plus they will be permanently inscribed in the info. section of your profile.
MMM;
$messageEmail2 = <<<MMM
B"H

However we have added some pretty cool functionality which allows you to add more Hebrew Dates to your profile for just $1 a pop.
http://apps.new.facebook.com/jewishdates/moreDates/

With this feature, you can add you kids' birthdays, your parents' birthdays, your grand parents' yahrtziets or anything else you can think of.

You will then be notified in many ways when that Hebrew day approaches, and even your friends can see it. Plus they will be permanently inscribed in the info. section of your profile.
MMM;
*/
$titleEmail = 'Here\'s a super easy way to give back';
$messageEmail2 = <<<MMM
Hey guys,

It’s been a while since you’ve heard from me. I’m the one who developed, created and maintains the JewishDates application to help you share your Jewish Pride, Pride in your Jewish Birthday, and keep track of your friends Jewish Birthdays.

I know you want to give back and show your appreciation for the hours on end that I put into this just for you. But moneys not really your thing.

So here is a chance to say thank you and actually help me out quite a bit just by clicking a few links.

My kids school is participating in the Kohls Cares campaign and are vying for a chance to win $500,000.

Just click http://apps.facebook.com/KohlsCares/school/1218381/cheder-chabad-of-monsey and vote for MY KIDS school “Cheder Chabad of Monsey”
If you have trouble finding “Cheder Chabad of Monsey” after you’ve authorized the Kohl App, Just click on the link in this email a second time.

You can vote 5 TIMES for each school, so please make sure to vote the FULL FIVE times for “Cheder Chabad of Monsey” before moving on.


Thank You

http://apps.facebook.com/KohlsCares/school/1218381/cheder-chabad-of-monsey

MMM;
$messageEmail1 = nl2br($messageEmail2);
	echo $message;
	while (ob_get_level() > 0) ob_end_flush();
	flush();

$allUsers=true;
//$batch=true;
$subBatchSize = 90;
$batchSize = 60;
$messageType = 3;	//	1=Notice, 2=Email, 3=Both;
$endLimit = 2500;

include '../facebookIncludes/postNotificationsWithBatch.php';
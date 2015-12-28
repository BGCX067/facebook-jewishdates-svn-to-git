<?
	function addBirthdayRecord()
	{
		global $facebook, $user;
		$userInfo = $facebook->api_client->fql_query("SELECT birthday FROM user WHERE uid=$user");

		dbConnect();
		$birthday = date("Y-m-d",strtotime($userInfo[0]['birthday']));
		
		$sql = "insert into fbJewishDates (uid, Birthday) values ('$user', '$birthday')";
		//echo $sql;
		mysql_query($sql);
		
		mysql_close();
	}
	function printJewishBirthday($birthday, $bornAtNight=false, $style=0, $displayCurrent=false, $displayLink=true)
	{
		$retval="<div ";
		if($style==2 || $style==4)$retval .= "align='center'";
		$retval .= "><fb:ref handle='Message'/>";
		if($displayCurrent)$retval .= "<fb:ref handle='Today_H'/><br />";
		$retval .= "My Hebrew Birthday is: <br />";
		$ahebdate = explode("/", strGregToHeb($birthday, false, $bornAtNight));
		switch ($style) {
			case 4: //english
				$retval .= "<b>" . $ahebdate[1] . " " . getJewishMonthName($ahebdate[0], $ahebdate[2]) . "</b>";	
				break;		
			case 3: //english
				$retval .= "<b>" . $ahebdate[1] . " " . getJewishMonthName($ahebdate[0], $ahebdate[2]) . " " . $ahebdate[2] . "</b><br />";	
				$retval .= "The next occurrence will be:<br />" . dateThisYear($ahebdate);
				break;
			case 2: //Hebrew
				$hebdate = strGregToHeb($birthday, true, $bornAtNight);
				$retval .= "<b>" . substr($hebdate, 0, strlen($hebdate)-10) . "</b>";
				break;
			case 1:
			default: //Hebrew
				$retval .= "<b>" . strGregToHeb($birthday, true, $bornAtNight) . "</b><br />";
				$retval .= "The next occurrence will be:<br />" . dateThisYear($ahebdate);
		}

		if( $displayLink ) $retval .= "<br /><fb:ref handle='Explanation'/>";
		return $retval . "</div>";
	}
	function dateThisYear($ahebdate)
	{
		$atodayhebrew = explode("/", strGregToHeb( date("M d, Y") ) );
		//Anyone born in addar should celebrate their birthday in in Adar II on a leap year.
		if($ahebdate[0] == 6 && !isLeapYear($ahebdate[2]) && isLeapYear($atodayhebrew[2]) ) $ahebdate[0] = 7;

		$date=strtotime(jdtogregorian(jewishtojd($ahebdate[0], $ahebdate[1], $atodayhebrew[2])));
		$today=strtotime("today");
		
		if ($date < $today) { 
			$datethisyear = date("M d, Y", strtotime(jdtogregorian(jewishtojd($ahebdate[0], $ahebdate[1], $atodayhebrew[2]+1))));
		}else{
			$datethisyear = date("M d, Y",$date);
		}
		return $datethisyear;
	}
	function strGregToHeb($strDate, $hebrew=false, $bornAtNight=false)
	{
		if($bornAtNight) $strDate = date("M d, Y",strtotime($strDate . " +1 day"));
		$tDate = getdate(strtotime($strDate));
		$hebdate = jdtojewish(gregoriantojd($tDate['mon'],$tDate['mday'],$tDate['year']), $hebrew);
		if ($hebrew) return iconv("ISO-8859-8", "UTF-8", $hebdate);
		else return $hebdate;
	}
	function getJewishMonthName($month, $year) {
		$monthNames = array("Tishrei", "Cheshvan", "Kislev", "Teves", "Shevat", "Adar I", "Adar II", "Nisan", "Iyar", "Sivan", "Tamuz", "Av", "Elul", "Adar");
		if($month == 6) { 
			if(isLeapYear($year)) {
				return $monthNames[5];
			} else {
				return $monthNames[13];
			}
		} else {
			if (isset($monthNames[$month - 1])) return $monthNames[$month - 1];
			else return $monthNames[$month]; //comment why this is neccesary
		}
	
	}
	
	function isLeapYear($year) {
		if($year % 19 == 0 || $year % 19 == 3 || $year % 19 ==6 || $year % 19 == 8 || $year % 19 == 11
				|| $year % 19 == 14 || $year % 19 == 17) { // 3rd, 6th, 8th, 11th, 14th, 17th or 19th years of 19 year cycle
			return true;
		} else {
			return false;
		}
	}
	
	function cmpDateThisYear($a, $b)
	{
		if($a["dateThisYear"] == null) return 1;
		if($b["dateThisYear"] == null) return -1;
		$aa = strtotime($a["dateThisYear"]);
		$bb = strtotime($b["dateThisYear"]);	
		if ($aa == $bb) {
			return 0;
		}
		return ($aa < $bb) ? -1 : 1;
	}
	function getFriendsBirthdays()
	{
		global $facebook;
		$friends = $facebook->api_client->fql_query("SELECT uid, name, birthday FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1=$facebook->user)");				
		$i=0;
		foreach($friends as $friend)
		{
			if(preg_match("/[a-zA-Z]+\s\d+,\s\d{4}/", $friend["birthday"]))
			{
				$i++;
				$ahebdate = explode("/", strGregToHeb($friend["birthday"]));
				$birthdays[$i]["uid"] = $friend["uid"];
				$birthdays[$i]["name"] = $friend["name"];
				$birthdays[$i]["hebBirthday"] = strGregToHeb($friend["birthday"], true);
				$birthdays[$i]["dateThisYear"] = dateThisYear($ahebdate);
			}
		}
		usort($birthdays, "cmpDateThisYear");
		return $birthdays;
	}
	function postUpgradeFeed()
	{
		global $facebook;
		$conn = dbConnect();
		$sql = "SELECT dateUpdated FROM fbUsers WHERE id='$facebook->user' AND appId='$facebook->api_key'";
		$results = mysql_query($sql, $conn);
		$rs = mysql_fetch_array($results);
		if($rs && strtotime($rs[0]) > strtotime('8/31/2008 11:00am')) return;
		echo date("M/d/Y h:m",strtotime($rs[0]));
		
		$sql = "SELECT BornAtNight, Birthday, style, displayCurrent, displayLink FROM fbJewishDates WHERE uid='$facebook->user'";
		$results = mysql_query($sql, $conn);
		if(!$rs = mysql_fetch_assoc($results))
		{
			addBirthdayRecord();
			$results = mysql_query($sql);
			$rs = mysql_fetch_assoc($results);
		}
		mysql_close($conn);

		$feedbundleId = 29410961889;
		$picture 	= 	$appcallbackurl.'images/Icon75x75.gif';
		$pLink		= 	'http://apps.facebook.com/jewishdates/';
		
		$messageData = json_encode(array(	"hebrewBirthday" => strGregToHeb($rs['Birthday'], true, $rs['BornAtNight']),
											"images" => array(array ("src" => $picture, "href" => $pLink))));
		try{
			$facebook->api_client->feed_publishUserAction($feedbundleId, $messageData);
				}catch(FacebookRestClientException $e){}
	}
	function updateJDateProfile($updateDB=true)
	{
		global $facebook;
		global $bBornAfterSunset, $profileDesign, $displayCurrent, $displayLink, $birthday, $success;
	
		dbConnect();
		if(isset($_POST["Submit"]) && $_POST["Submit"] == "Submit" && $updateDB)
		{
			$strBornAfterSunset = "";
			if(isset($_POST["chkSunset"]) && $_POST["chkSunset"] == "on")$strBornAfterSunset="true";
			else $strBornAfterSunset="false";
			
			$profileDesign = isset($_POST["profileDesign"]) ? $_POST["profileDesign"] : 1;
			$displayCurrent = isset($_REQUEST["chkToday"]);
			$displayLink = isset($_REQUEST["chkExplanation"]);
			$sql = "UPDATE fbJewishDates SET BornAtNight=$strBornAfterSunset, style=$profileDesign, displayLink='$displayLink', displayCurrent='$displayCurrent' WHERE uid=$facebook->user";
			mysql_query($sql) or die("You must un-install and re-install this app");
			$success = true;
		}
		$sql = "SELECT BornAtNight, Birthday, style, displayCurrent, displayLink FROM fbJewishDates WHERE uid='$facebook->user'";
		$results = mysql_query($sql);
		if(!$rs = mysql_fetch_assoc($results))
		{
			addBirthdayRecord();
			$results = mysql_query($sql);
			$rs = mysql_fetch_assoc($results);
		}
		mysql_close();
		$bBornAfterSunset = $rs['BornAtNight'];
		$profileDesign = $rs['style'];
		$displayCurrent = $rs['displayCurrent'];
		$displayLink = $rs['displayLink'];
		$birthday = date("M d, Y",strtotime($rs['Birthday']));
	
		//$userInfo = $facebook->api_client->fql_query("SELECT birthday FROM user WHERE uid=$user");
		//$birthday = $userInfo[0]['birthday'];
		
		$fbml = printJewishBirthday($birthday, $bBornAfterSunset, $profileDesign, $displayCurrent, $displayLink);
		$mobileFBML = $fbml;
		$mainFBML	= $fbml;
		
		$ahebdate = explode("/", strGregToHeb($birthday, false, $bornAtNight));
		$info_fields = array(
				array('field' => 'My Hebrew Birthday',
					  'items' => array(array('label'=> strGregToHeb($birthday, true, $bBornAfterSunset),
											 'description'=>'A kabbalisticly powerful day.',
											 'link'=>'http://apps.facebook.com/jewishdates/'))
				),
				array('field' => 'Next Occurence',
					  'items' => array(array('label'=> dateThisYear($ahebdate),
											 'description'=>'The next gregorian date that will corespond with my Hebrew Birthday',
											 'link'=>'http://apps.facebook.com/jewishdates/'))
				));
		$moreFBML = '<b><u>Special Dates</u></b><br />';
		$specialDays = DateRecord::findByWhere('DateRecord',"uid=$facebook->user");
        foreach($specialDays as $friend)
        {
			$moreFBML .=	'<div><b>'.$friend->data['title'].':</b>'.$friend->getHebrewDate('longeng').' - '
						.	$friend->getNextOccurance() . '</div>';
			$info_fields[] = array('field' => $friend->data['title'],'items' => array(
				array('label'=> $friend->getHebrewDate('longeng'), 'description'=> 'Hebrew Date', 'link'=>'http://apps.facebook.com/jewishdates/'),
				array('label'=> 'Next Occurance: '.$friend->getNextOccurance(), 'description'=> 'Gregorian Date this coming year', 'link'=>'http://apps.facebook.com/jewishdates/')
				));
        }
		
		$facebook->api_client->profile_setFBML($fbml.$moreFBML, $facebook->profileID, $fbml.$moreFBML, NULL, $mobileFBML, $mainFBML);
		$facebook->api_client->profile_setInfo('Jewish Dates', 1, $info_fields, $user);
		
		$refValue = "Todays Hebrew Date is:<br />" . strGregToHeb( date("M d, Y"), true);
		$facebook->api_client->fbml_setRefHandle("Today_H", $refValue);
		$facebook->api_client->fbml_setRefHandle("Message", "<fb:subtitle><a href='http://apps.facebook.com/jewishdates/'>Add this to my profile.</a></fb:subtitle>");
		//<div style='text-align:center;color:red;'>Help 'Jewish Dates'.<br />Support <a href='http://apps.facebook.com/jewishdates/supportChabadOfNewPaltz'>Chabad of New Paltz</a><hr /></div>
		$facebook->api_client->fbml_setRefHandle("Explanation", "<a href='http://www.chabad.org/library/article.asp?AID=144345'>What is a Jewish Birthday?</a>");
	}

	?>

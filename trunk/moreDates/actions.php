<?php
	$debug = false;
	require_once dirname(__FILE__) . '/../appinclude.php';
	require_once dirname(__FILE__) . '/helpers.php';
	require_once dirname(__FILE__) . '/dateRecord.php';
	if(isset($_REQUEST['action']))$action = strtolower($_REQUEST['action']);
	else $action = 'index';
	
    switch($action)
	{
		case 'index':
			$uid=$user;
			$records = DateRecord::findByWhere('DateRecord',"uid=$uid");
			if( isset($_REQUEST['insertedId']) )$insertedRecord = DateRecord::findById('DateRecord', $_REQUEST['insertedId']);
			if( count($records) == 0 )$action = 'welcome';
			break;
		case 'show':
			$rec = DateRecord::findById('DateRecord', $_REQUEST['id']);	
			break;		
		case 'new':
			$rec = new DateRecord();
			$nextAction = "create";
			$action = 'edit';
			break;
		case 'create':
			$rec = new DateRecord($_REQUEST);
			$rec->data['uid'] = $user;
			if($rec->save())
			{
				updateJDateProfile(false);
				postAddedFeed($rec);
				actionRedirect('index', 'flash=insert&insertedId='.$rec->data['id']);
			}
			else { $action = 'edit'; $nextAction='create'; }
			break;
		case 'edit':
			$rec = DateRecord::findById('DateRecord', $_REQUEST['id']);
			$nextAction = "update";
			if(!$rec)$action = 'show';
			break;
		case 'update':
			$rec = DateRecord::findById('DateRecord', $_REQUEST[$_REQUEST['hashNameSpace'].'id']);
			$rec->update($_REQUEST);
			if($rec->save())
			{
				updateJDateProfile(false);
				$action = 'show';
			}
			else { $action = 'edit'; $nextAction='update'; }
			break;
		case 'delete':
			$rec = DateRecord::findById('DateRecord', $_REQUEST['id']);	
			if($rec && $rec->delete())
			{
				updateJDateProfile(false);
				actionRedirect('index');
			}
			$action = 'show';
			break;
	}
	include 'views/template.php';
?>

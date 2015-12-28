<?php
	$debug = true;
	require_once dirname(__FILE__) . '/../appinclude.php';
	require_once dirname(__FILE__) . '/helpers.php';
	require_once dirname(__FILE__) . '/pollRecord.php';
	
	if(isset($_REQUEST['action']))$action = strtolower($_REQUEST['action']);
	else $action = 'list';
	if(isset($_REQUEST['outputtype']))$outputType = strtolower($_REQUEST['outputtype']);
	else $outputType = 'html';
	
	
    switch($action)
	{
		case 'list':
			$uid= isset($_REQUEST['user']) ? $_REQUEST['user'] : $user;
			$is_owner = ($user == $uid);
			$records = PollRecord::findByWhere('PollRecord',"owner_id='$uid'");
			if( isset($_REQUEST['insertedId']) )$insertedId = $_REQUEST['insertedId'];
			if( count($records) == 0 )$action = 'welcome';
			break;
		case 'show':
			$rec = PollRecord::findById('PollRecord', $_REQUEST['id']);	
			break;		
		case 'new':
			$rec = new ThoughtRecord();
			$nextAction = "create";
			$action = 'edit';
			break;
		case 'create':
			$rec = new ThoughtRecord($_REQUEST);
			if($rec->save())
			{
				actionRedirect('index', 'flash=insert&insertedId='.$rec->data['id']);
			}
			else { $action = 'edit'; $nextAction='create'; }
			break;
		case 'edit':
			$rec = ThoughtRecord::findById('ThoughtRecord', $_REQUEST['id']);
			$nextAction = "update";
			if(!$rec)$action = 'show';
			break;
		case 'update':
			$rec = ThoughtRecord::findById('ThoughtRecord', $_REQUEST[$_REQUEST['hashNameSpace'].'id']);
			$rec->update($_REQUEST);
			if($rec->save())
			{
				$action = 'show';
			}
			else { $action = 'edit'; $nextAction='update'; }
			break;
		case 'delete':
			$rec = ThoughtRecord::findById('ThoughtRecord', $_REQUEST['id']);	
			if($rec && $rec->delete())
			{
				actionRedirect('index');
			}
			$action = 'show';
			break;
	}
	
	switch($outputType)
	{
		case 'json':
			echo json_encode( $rec );
			break;
		default: 
			include 'views/template.php';
	}
?>

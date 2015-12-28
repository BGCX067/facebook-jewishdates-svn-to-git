<?
	include_once dirname(__FILE__) . '/../digifiss/digifiss.php';
	require_once dirname(__FILE__) . '/../fl_fbUtilInclude.php';
	require_once dirname(__FILE__) . '/helpers.php';
	require_once dirname(__FILE__) . '/thoughtRecord.php';

class ScriptServiceActions extends DigifiScriptService
{
	public function SaveRecord($id, $short, $full)
	{
		$rec = ThoughtRecord::findById('ThoughtRecord', $id);
		$rec->update( array('short'=>$short, 'full'=>$full) );
		if($rec->save())
		{
			return json_encode( $rec );		
		}else{
			return '{"error":"Did not save correctly"}';
		}
	}
}
new ScriptServiceActions();
?>
<?
class PassiveRecord
{
	public $data = array(), $orrginalValues = array(), $errors = array();
	//public $setCreatedAt = true;
	public $tableName='';
	public $collumns = array();
	
	public function __construct($tHash=null)
	{
		$this->update($tHash);
	}
	
	public function update($tHash)
	{
		$nameSpace = '';
		if(isset($tHash['hashNameSpace']))$nameSpace = $tHash['hashNameSpace'];
		if(isset($tHash[$nameSpace.'id']))
		{
			$this->data['id'] = $tHash[$nameSpace.'id'];
		}
		if($tHash[$nameSpace.'updated_at'])$this->data['updated_at'] = $tHash[$nameSpace.'updated_at'];
		foreach($this->collumns as $col)
		{
			if(isset($tHash[$nameSpace.$col]))
			{
				$this->data[$col] = $tHash[$nameSpace.$col];
			}elseif( isset($tHash[$nameSpace.'not_'.$col]) ){
				print_r_debug("Setting replace value for $col ");
				$this->data[$col] = $tHash[$nameSpace.'not_'.$col];
			}elseif(!isset($this->data[$col])){
				print_r_debug("Setting $col to null ");
				$this->data[$col] = null;
			}
		}
		print_r_debug($this->data);
	}
	public function save()
	{
		$retVal = true;
		$conn = self::connection();
		if(isset($this->data['id']))
		{
			$sql = 	"UPDATE $this->tableName SET ";
			foreach($this->collumns as $col) $sql .= "$col = '" . mysql_real_escape_string($this->data[$col], $conn) . "', ";
			$sql .=	"id=id WHERE id=".$this->data['id'];
		}else{
			if(array_key_exists('created_at', $this->data) && empty($this->data['created_at']))
			{
				$this->data['created_at'] = date('Y-m-d H:i:s');
			}
			$sql =	"INSERT INTO $this->tableName ("
				. $this->newJoin(",", $this->collumns, true, false)
				. ") VALUES ("
				. $this->newJoin(",", $this->data, true, true)
				. ")";
		}
		$results = mysql_query($sql, $conn);
		if(!$this->recordErrors($sql, $conn))$retVal = false;
		elseif(!isset($this->data['id']))$this->data['id'] = mysql_insert_id($conn);
		mysql_close($conn);
		return $retVal;
	}
	public function delete()
	{
		if(!isset($this->data['id']))return false;
		$retVal = true;
		$conn = self::connection();
		$sql = "DELETE FROM $this->tableName WHERE id=" . $this->data['id'];
		$results = mysql_query($sql, $conn);
		if(!$this->recordErrors($sql, $conn))$retVal = false;
		mysql_close($conn);
		return $retVal;
	}
	public static function findById($className, $id)
	{
		$arr = self::findByWhere($className, 'id='.$id);
		if(count($arr) > 0)return $arr[0];
		else return null;
	}
	public static function findByWhere($className, $sqlWhere)
	{
		$class = new ReflectionClass($className);
		$props = $class->getDefaultProperties();
		return self::findBySQL($className, "SELECT * FROM $props[tableName] WHERE $sqlWhere");
	}
	public static function findBySQL($className, $sql)
	{
		$class = new ReflectionClass($className);
		
		$arr = array();
		print_r_debug($sql);
		$conn = self::connection();
		$results = mysql_query($sql, $conn);
		while($rs = mysql_fetch_assoc($results))
		{
			$arr[] = $class->newInstance($rs);
		}
		if(count($arr) == 0)
		{
			$rec = $class->newInstance();
			if(!$rec->recordErrors($sql, $conn))$arr[] = $rec;
		}
		mysql_close($conn);
		return $arr;		
	}
	private function connection()
	{
		return dbConnect();
	}
	private function newJoin($glue, $list, $includeNulls = true, $wrapStrings = false)
	{
		$str = ''; $glue2 = ''; $i = 0;
		$q = $wrapStrings ? '\'' : '';
		foreach($list as $value)
		{
			if($wrapStrings)$value = mysql_real_escape_string($value, self::connection());
			if($includeNulls || $value != null)
				$str .= $glue2 . $q . $value . $q;
			$glue2 = $glue;
		}
		return $str;
	}
	private function recordErrors($sql, $conn)
	{
		if(mysql_errno($conn) != 0)
		{
			$this->errors["sql"] = $sql;
			$this->errors["sqlError"] = mysql_error($conn);
			return false;
		}
		return true;
	}
}

function textFieldFor($rec, $key, $label=null)
{
	?>
	<span class="fieldWrapper <?=$rec->errors[$key]!=null ? 'fieldInError' : ''?>" >
		<label for="txt_<?=$key?>_<?=$rec->data['id']?>"><?=isset($label)?$label:$key?>:</label>&nbsp;
		<textarea name="txt_<?=$key?>" id="txt_<?=$key?>_<?=$rec->data['id']?>" class="textInput"
				style="overflow:hidden;" onkeyup="checkTextAreaRows(this)"
				><?=htmlentities($rec->data[$key])?></textarea>
		<script>checkTextAreaRows(document.getElementById("txt_<?=$key?>_<?=$rec->data['id']?>"));</script>
	</span>
	<?
}
function checkFieldFor($rec, $key, $label=null)
{
	?>
	<span class="fieldWrapper <?=$rec->errors[$key]!=null ? 'fieldInError' : ''?>" >
		<label for="txt_<?=$key?>"><?=isset($label)?$label:$key.':'?></label>&nbsp;
		<input type="checkbox" name="txt_<?=$key?>" id="txt_<?=$key?>" <? if($rec->data[$key]){?>checked="checked"<?}?> value="1" />
		<input type="hidden" name="txt_not_<?=$key?>" value="0" />
	</span>
	<?
}
?>
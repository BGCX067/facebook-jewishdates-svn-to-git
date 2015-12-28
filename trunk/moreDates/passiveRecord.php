<?
class PassiveRecord
{
	public static $conn;
	public $data = array(), $orrginalValues = array(), $errors = array();
	//public $setCreatedAt = true;
	public $tableName='', $collumns = array();
	
	public function __construct($tHash=null)
	{
		$this->update($tHash);
	}
	
	public function update($tHash)
	{
		$nameSpace = '';
		if(isset($tHash['hashNameSpace']))$nameSpace = $tHash['hashNameSpace'];
		if($tHash[$nameSpace.'id'])$this->data['id'] = $tHash[$nameSpace.'id'];
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
		if(isset($this->data['id']))
		{
			$sql = 	"UPDATE $this->tableName SET ";
			foreach($this->collumns as $col) $sql .= "$col = '" . mysql_real_escape_string($this->data[$col]) . "', ";
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
		$results = mysql_query($sql, self::connection());
		if(!$this->recordErrors($sql))return false;
		if(!isset($this->data['id']))$this->data['id'] = mysql_insert_id(self::connection());
		return true;
	}
	public function delete()
	{
		if(!isset($this->data['id']))return false;
		$sql = "DELETE FROM $this->tableName WHERE id=" . $this->data['id'];
		$results = mysql_query($sql, self::connection());
		if(!$this->recordErrors($sql))return false;
		return true;
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
		$arr = array();
		$rec = $class->newInstance();
		$tableName = $rec->tableName;
		$sql = "SELECT * FROM $tableName WHERE $sqlWhere";
		print_r_debug($sql);
		$results = mysql_query($sql, self::connection());
		while($rs = mysql_fetch_assoc($results))
		{
			$arr[] = $class->newInstance($rs);
		}
		if(count($arr) == 0)
		{ 
			if(!$rec->recordErrors($sql))$arr[] = $rec;
		}
		return $arr;
	}
	private function connection()
	{
		if(!self::$conn)self::$conn = dbConnect();
		return self::$conn;
	}
	private function newJoin($glue, $list, $includeNulls = true, $wrapStrings = false)
	{
		$str = '';$i=0;
		$q = $wrapStrings ? '\'' : '';
		$length = count($list);
		foreach($list as $value)
		{
			$i++;
			if($wrapStrings)$value = mysql_real_escape_string($value, self::connection());
			if($includeNulls || $value != null)
				$str .= $q . $value . $q . ($i < $length ? ',' : '');
		}
		return $str;
	}
	private function recordErrors($sql)
	{
		if(mysql_errno(self::connection()) != 0)
		{
			$this->errors["sql"] = $sql;
			$this->errors["sqlError"] = mysql_error(self::connection());
			return false;
		}
		return true;
	}
}

function textFieldFor($rec, $key, $label=null)
{
	?>
	<span class="fieldWrapper <?=$rec->errors[$key]!=null ? 'fieldInError' : ''?>" >
		<label for="txt_<?=$key?>"><?=isset($label)?$label:$key?>:</label>&nbsp;
		<input type="text" name="txt_<?=$key?>" id="txt_<?=$key?>" value="<?=$rec->data[$key]?>" />
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

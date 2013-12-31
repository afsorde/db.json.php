<?php

function implode_if($glue, $values) {
	return is_array($values) ? implode($glue, $values) : $values;
}

function create_db_cond($field, $operator, $value) {
	$retVal = 'true';
	switch ($operator) {
		case 'is' :
			$retVal = "($field IS $value)";
			break;
		case 'nq' :
			$retVal = "($field<>'$value')";
			break;
		case 'eq' :
			$retVal = "($field='$value')";
			break;
		case 'nt' :
			$retVal = "($field not like '$value')";
			break;
		case 'et' :
			$retVal = "($field like '$value')";
			break;
		case 'ct' :
			$retVal = "($field like '%$value%')";
			break;
		case 'gt' :
			$retVal = "($field>'$value')";
			break;
		case 'lt' :
			$retVal = "($field<'$value')";
			break;
		case 'in' :
			$retVal = "( $field IN ('" . implode("','", $value) . "'))";
			break;
		case 'nn' :
			$retVal = "( $field NOT IN ('" . implode("','", $value) . "'))";
			break;
	}
	return $retVal;
}

function create_db_list_cond($list_cond, $glue = 'and') {
	$ret_arr = array();
	foreach ($list_cond as $field => $cond) {
		foreach ($cond as $operator => $value) {
			$ret_arr[] = create_db_cond($field, $operator, $value);
		}
	}
	return '(' . implode(" $glue ", $ret_arr) . ')';
}

class php_db_table {
	var $db = false;
	var $name = '';

	function php_db_table($name, $db) {
		$this -> db = $db;
		$this -> name = $name;

	}

	function insert($set, $has_auto_id = false) {
		$fields = array();
		foreach ($set as $field => $val)
			$fields[] = $field;
		$fstr = implode(', ', $fields);
		$sstr = "'" . implode('\', \'', $set) . "'";
		$sqlStr = "insert into $this->name ($fstr) values ($sstr)";
		if ($this -> db -> query($sqlStr))
			if ($has_auto_id)
				return $this -> db -> lid();
			else
				return true;
		else
			return false;
	}

	function getlist($fields = "*", $conds = false, $orders = false, $groups = false, $limit = false, $page = 1, $index = false) {
		$sqlStr = 'SELECT ' . implode_if(', ', $fields) . " FROM $this->name";
		if ($conds)
			$sqlStr .= ' WHERE ' . create_db_list_cond($conds);
		if ($orders)
			$sqlStr .= ' ORDER BY ' . implode_if(', ', $orders);
		if ($groups)
			$sqlStr .= ' GROUP BY ' . implode_if(', ', $groups);
		$pointer = $limit * ($page - 1);
		if ($limit)
			$sqlStr .= " LIMIT $pointer, $limit";
		if ($index)
			return $this -> db -> indexed_table($sqlStr, $index, 2);
		else
			return $this -> db -> table($sqlStr, 2);
	}

	function getRecord($fields = "*", $conds = false, $orders = false, $groups = false) {
		$sqlStr = 'SELECT ' . implode_if(', ', $fields) . " FROM $this->name";
		if ($conds)
			$sqlStr .= ' WHERE ' . create_db_list_cond($conds);
		if ($orders)
			$sqlStr .= ' ORDER BY ' . implode_if(', ', $orders);
		if ($groups)
			$sqlStr .= ' GROUP BY ' . implode_if(', ', $groups);
		return $this -> db -> record($sqlStr);
	}

	function createView($name, $fields = "*", $conds = false, $orders = false, $groups = false) {
		$sqlStr = 'CREATE OR REPLACE VIEW $name AS  SELECT ' . implode_if(', ', $fields) . " FROM $this->name";
		if ($conds)
			$sqlStr .= ' WHERE ' . create_db_list_cond($conds);
		if ($orders)
			$sqlStr .= ' ORDER BY ' . implode_if(', ', $orders);
		if ($groups)
			$sqlStr .= ' GROUP BY ' . implode_if(', ', $groups);
		return $this -> db -> query($sqlStr);
	}

	function update($conds, $set) {
		$uarr = array();
		$carr = array();
		foreach ($set as $field => $val)
			$uarr[] = "$field='$val'";
		$ustr = implode(', ', $uarr);
		if ($conds)
			$cstr = create_db_list_cond($conds);
		$sqlStr = "UPDATE $this->name SET $ustr WHERE $cstr";
		if ($this -> db -> query($sqlStr))
			return mysql_affected_rows();
		else
			return false;
	}

	function delete($conds) {
		$sqlStr = "DELETE FROM $this->name WHERE " . create_db_list_cond($conds);
		if ($this -> db -> query($sqlStr))
			return mysql_affected_rows();
		else
			return false;
	}

}
?>

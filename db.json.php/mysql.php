<?php

function mysql_real_escape_array($arr) {
	if (is_array($arr)) {
		$retVal = array();
		foreach ($arr as $key => $value)
			$retVal[$key] = mysql_real_escape_array($value);
	} else {
		$retVal = mysql_real_escape_string($arr);
	}
	return $retVal;
}

class php_db_mysql {
	var $conection;

	function php_db_mysql($db_name, $db_user = 'root', $db_password = '', $db_host = 'localhost') {
		$this -> conection = mysql_pconnect($db_host, $db_user, $db_password);
		if ($this -> conection) {

			mysql_set_charset('utf8', $this -> conection);
			if (!mysql_select_db($db_name, $this -> conection)) {

				mysql_close($this -> conection);
				$this -> conection = NULL;
			}
		}
	}

	function query($str) {
		if ($this -> conection)
			return mysql_query($str, $this -> conection);
		else
			return false;
	}

	function ret($res, $m = 2) {
		$retVal = false;

		if ($res)
			switch($m) {
				case 1 :
					$retVal = mysql_fetch_row($res);
					break;
				case 2 :
					$retVal = mysql_fetch_assoc($res);
					break;
				case 3 :
					$retVal = mysql_fetch_array($res);
					break;
			}
		return $retVal;
	}

	function table($str, $m = 3) {
		if ($res = $this -> query($str)) {
			$retVal = array();
			while ($rec = $this -> ret($res, $m))
				$retVal[] = $rec;
			return $retVal;
		} else
			return false;
	}

	function indexed_table($str, $index, $m = 3) {
		if ($res = $this -> query($str)) {
			$retVal = array();
			if (is_array($index)) {
				$ind = end($index);
				unset($index[count($index) - 1]);
				while ($rec = $this -> ret($res, $m)) {
					$arr = $rec;
					foreach ($index as $key => $val) {
						$arr = array($rec[$val] => $arr);
					}
					if (is_array($retVal[$rec[$ind]])) {
						$retVal[$rec[$ind]] = $retVal[$rec[$ind]] + $arr;
					} else {
						$retVal[$rec[$ind]] = $arr;
					}
				}
			} else
				while ($rec = $this -> ret($res, $m))
					$retVal[$rec[$index]] = $rec;
			return $retVal;
		} else
			return false;
	}

	function record($str, $m = 3) {
		if ($res = $this -> query($str))
			return $this -> ret($res, $m);
		else
			return false;
	}

	function field($str, $f = 0) {
		if ($res = $this -> query($str)) {
			if ($rec = $this -> ret($res, 3))
				return $rec[$f];
			else
				return false;
		} else
			return false;
	}

	function lid() {
		return mysql_insert_id($this -> conection);
	}

	function rows($table) {
		if ($this -> conection) {
			$res = $this -> query("select count(*) as rows from $table");
			$ret = $this -> ret($res, 2);
			return $ret['rows'];
		} else
			return false;
	}

}
?>

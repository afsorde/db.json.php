<?php

/*
 * edit these values to connect to your database
 */
define("PHP_DB_HOST", "localhost", true);
define("PHP_DB_NAME", "database_name", true);
define("PHP_DB_USER", "username", true);
define("PHP_DB_PASSWORD", "password", true);

$php_db_tables_realation = array(
	/*
	 * sample: 'table1>table2' => 'table1.field3=table2.field4';
	 */
);

function php_db_class_security_accesslist($table, $action) {
	/*
	 * you should write your codes below here that returns access status
	 * true means user can fetch data and false blocking this action
	 */
	return true;
}
?>

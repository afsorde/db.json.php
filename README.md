db.json.php
===========

A complete PHP &amp; MySQL package, Use javascript or any other client side languages to working with server database

Installation
===========
At first you need to set the configuration file: `custom.php`


All dabatabe connection details needed. Just fill them right.

    define("PHP_DB_HOST", "localhost", true);
    define("PHP_DB_NAME", "database_name", true);
    define("PHP_DB_USER", "username", true);
    define("PHP_DB_PASSWORD", "password", true);


After that you can determine all realationship between tables for JS uses.

    function php_db_class_security_accesslist($table, $action) {
        	/*
        	* sample: 'table1>table2' => 'table1.field3=table2.field4';
        	*/
        'letter>contact'=>'letter.id=contact.letter',
        'letter>station'=>'letter.station=station.id',
        'station>equipment'=>'station.id=equipment.station'
    }

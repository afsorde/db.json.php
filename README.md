db.json.php
===========

A complete PHP &amp; MySQL package, Use javascript or any other client side languages to working with server database

Installation
===========
At first you need to set the configuration file: `custom.php`




All dabatabe connection details needed. Just fill them right.

```
define("PHP_DB_HOST", "localhost", true);
define("PHP_DB_NAME", "database_name", true);
define("PHP_DB_USER", "username", true);
define("PHP_DB_PASSWORD", "password", true);
```

`PHP_DB_HOST` Database host name ex. localhost or 20.99.48.12

`PHP_DB_NAME` Database name ex. mydb

`PHP_DB_USER` Database username ex. root

`PHP_DB_PASSWORD` Database password ex. password of root uasername


After that you can determine all realationship between tables for JS uses.
```
function php_db_class_security_accesslist($table, $action) {
    /*
    * sample: 'table1>table2' => 'table1.field3=table2.field4';
    */
    'letter>contact'=>'letter.id=contact.letter',
    'letter>station'=>'letter.station=station.id',
    'station>equipment'=>'station.id=equipment.station'
}
```


Usage
===========
To Use this class easily you can use a javascript source code on client side or a php file in server side:

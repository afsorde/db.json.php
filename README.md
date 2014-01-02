db.json.php
===========

A complete PHP &amp; MySQL package, Use javascript or any other client side languages to working with server database

Installation
===========
At first you need to set the configuration file: `custom.php`




All dabatabe connection details needed. Just fill them right.

```php
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
```php
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


***JavaScript/JQuery usage***

Just posting an ayyar to server is enough for doing actions from a web client
```js
$.post('mysql.json.php', {
	params : {
		1 : {
			table : 'table1',
			action : 'update',
			set:{
			    field1:12,
			    field2:'newvalue'
			},
			where : {
				status : {
					eq : 'active'
				}
			}
		}
	}
}, function(data) {

}, 'json');
```
**parameters**

`table` is a table name or using `>` to create a LEFT JOIN ex.`table1>table2>table3`

`action` is the SQL method of the procedure
    `select` or `select>list` giving back a record list and have many options such az `group`, `order`, `where`, `limit`, `page`

<table>
  <tr>
    <th>Parameter</th>
    <th>values</th>
    <th>Usage</th>
    <th>Description</th>
  </tr>
  <tr>
    <td rowspan="2">table</td>
    <td>any table name or jont tables</td>
    <td rowspan="2">All Actions</td>
    <td>ex. table1</td>
  </tr>
  <tr>
    <td>jont tables</td>
    <td>table1>ex. table2</td>
  </tr>
  <tr>
    <td rowspan="6">action</td>
    <td>select or select>list</td>
    <td rowspan="6">To set actions</td>
    <td rowspan="6"></td>
  </tr>
  <tr><td>select>record</td></tr>
  <tr><td>update</td></tr>
  <tr><td>insert</td></tr>
  <tr><td>insert>getid</td></tr>
  <tr><td>delete</td></tr>
</table>


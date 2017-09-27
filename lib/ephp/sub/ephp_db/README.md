# ephp_db
Non-invasive PDO wrapper for PHP.

## Features
- PDO is not subclassed. You can use the wrapper locally without changing your code globally.
- Improves code clarity at executing statements and fetching results
- Organize your sql statements strings in one class
- You can always access to pure PDO features
- Only wraps PDO and not SQL. Trying to do it is almost always a mistake.

## How it looks
```php
require_once(__DIR__ . '/ephp_db/include.php');

//You can subclass wrapper class to define queries
class MyDb extends \ephp\db\Db {
  const my_create = 'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT)';
  const my_insert = 'INSERT INTO users (id, name) VALUES (?, ?)';
  const my_select = 'SELECT id, name FROM users WHERE name = ?';
  const my_select_all = 'SELECT id, name FROM users';
}

$db = new MyDb;
//$db = new \ephp\db\Db; //if you don't subclass wrapper class

$db->pdo = \ephp\db\Db::sqlite(':memory:');
//$db->pdo = \ephp\db\Db::sqlite('my_database.sqlite');
//$db->pdo = new \PDO('sqlite:memory:');

$db->call('my_create');
$db->call('my_insert', 0, 'edwin');
$db->call('my_insert', 1, 'edgar');

//$db('SELECT * FROM users'); //run arbitrary query, useful when you not subclassed wrapper class

//use =get= for single results
if ( $row = $db->get('my_select', 'edwin') ) {
  var_dump($row);
}

//use =for_reach= for multiple result
foreach ( $db->for_each('my_select_all') as $row ) {
  var_dump($row);
}
```

## Demo
Run the following commands to download and run the demo

```sh
php -d allow_url_include=On -r "require('https://raw.githubusercontent.com/edwrodrig/ephp_db/master/scripts/demo.php');"
cd demo
php RUNME.php
```
See the [examples](https://github.com/edwrodrig/ephp_db/tree/master/examples) and [test](http://github.com/edwrodrig/ephp_db/tree/master/test) for more information

## How to include this library in my code
Run the following command to download the code
```sh
php -d allow_url_include=On -r "require('https://raw.githubusercontent.com/edwrodrig/ephp_db/master/scripts/lib.php');"
```
You will see a `ephp_db` folder with a `include.php` file. Just include that file in your project.
```php
require('path/to/ephp_db/include.php');
```
Or include it using composer
```sh
composer require edwrodrig/ephp_db
```




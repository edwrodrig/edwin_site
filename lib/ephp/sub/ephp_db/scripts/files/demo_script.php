<?php

require_once(__DIR__ . '/ephp_db/include.php');

class MyDb extends \ephp\db\Db {
  const my_create = 'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT)';
  const my_insert = 'INSERT INTO users (id, name) VALUES (?, ?)';
  const my_select = 'SELECT id, name FROM users WHERE name = ?';
  const my_select_all = 'SELECT id, name FROM users';
}


$db = new MyDb;
$db->pdo = \ephp\db\Db::sqlite(':memory:');
//$db->pdo = \ephp\db\Db::sqlite('my_database.sqlite');
//$db->pdo = new \PDO('sqlite:memory:');

$db->call('my_create');
$db->call('my_insert', 0, 'edwin');
$db->call('my_insert', 1, 'edgar');


//use =get= for single results
if ( $row = $db->get('my_select', 'edwin') ) {
  var_dump($row);
}


//use =for_reach= for multiple result
foreach ( $db->for_each('my_select_all') as $row ) {
  var_dump($row);
}


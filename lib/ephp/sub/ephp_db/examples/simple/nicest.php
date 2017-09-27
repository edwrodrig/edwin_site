<?php

require_once(__DIR__ . '/../../include.php');

class MyDb extends \ephp\db\Db {
  const my_create = 'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT)';
  const my_insert = 'INSERT INTO users (id, name) VALUES (?, ?)';
  const my_select = 'SELECT id, name FROM users WHERE name = ?';
}


$db = new MyDb;
$db->pdo = \ephp\db\Db::sqlite(':memory:');

$db->call('my_create');
$db->call('my_insert', 0, 'edwin');


if ( $row = $db->get('my_select', 'edwin') ) {
  var_dump($row);
}

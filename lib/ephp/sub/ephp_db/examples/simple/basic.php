<?php

require_once(__DIR__ . '/../../include.php');

$db = new \ephp\db\Db;
$db->pdo = \ephp\db\Db::sqlite(':memory:');

$db('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT)');
$db('INSERT INTO users (id, name) VALUES (?, ?)', 0, 'edwin');

$result = $db('SELECT id, name FROM users WHERE name = ?', 'edwin');
if ( $row = $result->fetch(\PDO::FETCH_ASSOC) ) {
  var_dump($row);
}

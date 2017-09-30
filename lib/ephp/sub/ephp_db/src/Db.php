<?php
namespace ephp\db;

class Db {

public $pdo = null;

function __invoke(string $str, ...$args) {
  $s = $this->pdo->prepare($str);
  $i = 1;
  foreach ( $args as $arg )
    $s->bindValue($i++, $arg);
  if ( !$s->execute() ) {
    throw new \Exception($s->errorInfo()[2] ?? 'Error at query');
  }
  return $s;
}

function call($name, ...$args) {
  $r = new \ReflectionClass($this);
  $constants = $r->getConstants();
  if ( isset($constants[$name]) ) {
    return $this($constants[$name], ...$args);
  } else {
    throw new \Exception('Query not exists!');
  }
}

function table_exists($name) {
  try {
    $this("SELECT 1 FROM $name");
    return true;
  } catch ( \Exception $e ) {
    return false;
  }
}

function get($name, ...$args) {
  $rr = $this->call($name, ...$args);
  return $rr->fetch(\PDO::FETCH_ASSOC);
}

function for_each($name, ...$args) {
  $rr = $this->call($name, ...$args);
  while ( $r = $rr->fetch(\PDO::FETCH_ASSOC) ) {
    yield $r;
  }
}

function create() {
  $r = new \ReflectionClass($this);
  $constants = $r->getConstants();
  foreach ( $constants as $c ) {
    if ( strpos($c, 'CREATE TABLE') !== 0 ) continue;
    $this($c);
  }
}

function last_id() {
  return $this->pdo->lastInsertId();
}

function begin() {
  return $this->pdo->beginTransaction();
}

function commit() {
  return $this->pdo->commit();
}

static function sqlite($filename = ':memory:') {
  $pdo = new \PDO('sqlite:' . $filename);
  $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  return $pdo;
}

}


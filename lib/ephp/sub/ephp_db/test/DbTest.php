<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');


class DbTest extends TestCase {

function testCallings() {
  $db = new class extends \ephp\db\Db {
    const create = "CREATE TABLE info(id INTEGER, txt TEXT)";
    const insert = "INSERT INTO info (id, txt)  VALUES (?,?)";
    const select = "SELECT id, txt FROM info";
  };

  $db->pdo = \ephp\db\Db::sqlite();
  $db->call('create');

  $this->assertEquals([], $db->call('select')->fetchAll());
 
  $db->call('insert', 1, 'hola');

  $this->assertEquals([['id' => 1, 'txt' => 'hola']], $db->call('select')->fetchAll(\PDO::FETCH_ASSOC));
  foreach ( $db->for_each('select') as $r ) {
    $this->assertEquals(['id' => 1, 'txt' => 'hola'], $r);
  }

  $this->assertEquals(['id' => 1, 'txt' => 'hola'], $db->get('select'));
}

function testCreate() {
  $db = new class extends \ephp\db\Db {
    const create_a = "CREATE TABLE aaa(id INTEGER, txt TEXT)";
    const create_b = "CREATE TABLE bbb(id INTEGER, txt TEXT)";
  };

  $db->pdo = \ephp\db\Db::sqlite();
  $db->create();

  
  $this->assertEquals(['aaa', 'bbb'], $db("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(\PDO::FETCH_COLUMN));
}

function testLastId() {
  $db = new class extends \ephp\db\Db {
    const create_a = "CREATE TABLE aaa(id INTEGER AUTO INCREMENT, txt TEXT)";
  };

  $db->pdo = \ephp\db\Db::sqlite();
  $db->create();

  $db('INSERT INTO aaa (txt) VALUES (?)', 'hola');

  $this->assertEquals(1, $db->last_id());

  $db('INSERT INTO aaa (txt) VALUES (?)', 'hola');

  $this->assertEquals(2, $db->last_id()); 
}

function testMalformedQuery() {
  $db = new \ephp\db\Db;
  $db->pdo = \ephp\db\Db::sqlite();
  try {
    $db('AAABB');
    $this->assertTrue(false, 'malformed query should except');
  } catch ( \Exception $e ) {
    $this->assertTrue(true);
  }
}

function testTableExists() {
  $db = new class extends \ephp\db\Db {
    const create_a = "CREATE TABLE aaa(id INTEGER AUTO INCREMENT, txt TEXT)";
  };

  $db->pdo = \ephp\db\Db::sqlite();
  $db->create();

  $this->assertTrue($db->table_exists('aaa'), 'table should exists');
  $this->assertFalse($db->table_exists('bbb'), ' table shouldn\'t exists');
}

function testReInsert() {
  $db = new class extends \ephp\db\Db {
    const create_a = "CREATE TABLE aaa(id TEXT PRIMARY KEY)";
  };

  $db->pdo = \ephp\db\Db::sqlite();
  $db->create();

  $db('INSERT INTO aaa VALUES (?)', 'hola');

  try {
    $db('INSERT INTO aaa VALUES (?)', 'hola');
    $this->assertTrue(false, 'should except');
  } catch ( \Exception $e ) {
    $this->assertTrue(true, 'should except');
  }
}

function testSelectWithMoreColumns() { 
  $db = new class extends \ephp\db\Db {
    const create_a = "CREATE TABLE aaa(id TEXT PRIMARY KEY)";
  };
  
  $db->pdo = \ephp\db\Db::sqlite();
  $db->create();
 
  try {  
  $db('SELECT id, data FROM aaa');
    $this->assertTrue(false, 'should except');
  } catch ( \Exception $e ) {
    //echo $e->getMessage();
    $this->assertTrue(true, 'should except');
  }
}


}

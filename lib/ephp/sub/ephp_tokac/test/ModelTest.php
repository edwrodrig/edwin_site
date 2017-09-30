<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ModelTest extends TestCase {

static public $db;
static public $model;
static public $actions;

public static function setUpBeforeClass() {
  self::$db = new \ephp\tokac\Db;
  self::$model = new \ephp\tokac\Model;
  self::$model->db = self::$db;
  self::$model->request->add_action(new class {
    function test_action($a, $b, $c) {
      return ['A' => $a, 'B' => $b, 'C' => $c];
    }
  });

}

public function setUp() {
  self::$db->pdo = \ephp\db\Db::sqlite();
  self::$db->create();
}

function testCheckEntry() {
  $r = self::$model->entry_create(['action' => 'test_action', 'a' => 'a_value'], ['b' => 'b_value']);
  $token = $r['token'];

  $this->assertEquals($r, self::$model->entry_check($token));
  $this->assertEquals(['b' => 'b_value', 'token' => $token], self::$model->entry_check($token));
}

function testExecuteEntry() {
  $token = self::$model->entry_create(['action' => 'test_action', 'a' => 'a_value'], ['b' => 'b_value']);
  $token = $token['token'];

  $this->assertEquals(['A' => 'a_value', 'B' => 'b_value_c', 'C' => 'c_value'], self::$model->entry_execute($token, ['b' => 'b_value_c', 'c' => 'c_value']));
}

}

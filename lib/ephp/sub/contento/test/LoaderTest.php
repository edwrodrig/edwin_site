<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class LoaderTest extends TestCase {

public static $action;

public function setUp() {
  $loader = new class extends \contento\Loader {

    function init_contento() {
      parent::init_contento();

      $this->usac->db->create();
      $this->tokac->db->create();
      $this->contento->data->db->create();
      $this->contento->data->db->create();

      $this->usac->model->user_create('edwin', 'pass', 'edwin@main.com');

      $collection = new \contento\CollectionBuilder();
      $collection->add([
        'name' => 'data', 'type' => 'object', 'fields' => [
        ['field' => 'id', 'type' => 'id', 'display' => true],
        ['field' => 'a', 'type' => 'string', 'display' => true],
        ['field' => 'b', 'type' => 'string']]
      ]);

      $collection->add(['name' => 'collec', 'type' => 'collection', 'elem' => [ 'type' => 'custom', 'type_name' => 'data']]);


      foreach ( $collection->collections as $col ) {
        $this->contento->data->model->collection_add($collection->resolve_type($col));
      }
    }
  };  

  $loader->set_config(['console_enabled' => false, 'usac' => ['db' => ':memory:']]);
  
  $loader->init_actions();

  $request = new \ephp\mvc\RequestAssoc;
  $request->retrieve($loader->request);
  self::$action = new \ephp\mvc\ResponseAssoc;
  self::$action->request = $request;
}

public static function req(array $data) {
  return (self::$action)($data);
}

function testUserLogin() {
  $r = self::req(['action' => 'user_login', 'username' => 'edwin', 'password' => 'pass']);
  $this->assertEquals(0, $r['status']);
  $this->assertInternalType('string', $r['data']['session']);
  return $r['data']['session'];
}

function testAddOk() {
  $session = $this->testUserLogin();
  $r = self::req(['action' => 'contento_data_add', 'session' => $session, 'data' => ['id' => 'data', 'a' => 'value1', 'b' => 'value2'], 'collection' => 'collec']);
  $this->assertEquals(['status' => 0, 'data' => ['id' => 'data']], $r);
  return $session;
}

function testAddNoId() {
  $session = $this->testUserLogin();
  $r = self::req(['action' => 'contento_data_add', 'session' => $session, 'data' => ['a' => 'value1', 'b' => 'value2'], 'collection' => 'collec']);
}

function testGetJson() {
  $session = $this->testAddOk();

  $r = self::req(['action' => 'contento_data_by_collection', 'session' => $session, 'collection' => 'collec']);
  $this->assertEquals(['id' => 'data', 'a'=> 'value1'], $r['data'][0]['data']);

  $r = self::req(['action' => 'contento_data_by_name_collection', 'session' => $session, 'name' => 'data', 'collection' => 'collec']);
  $this->assertEquals(['id' => 'data', 'a' => 'value1', 'b' => 'value2'], $r['data']['data']);
}

function testUpdateJson() {
  $session = $this->testAddOk();
  $r = self::req(['action' => 'contento_data_update', 'session' => $session, 'name' => 'data', 'data' => ['id' => 'data', 'a' => 'value3', 'b' => 'value4'], 'collection' => 'collec']);
  $this->assertEquals(['status' => 0, 'data' => ['id' => 'data']], $r);

  $r = self::req(['action' => 'contento_data_by_name_collection', 'session' => $session, 'name' => 'data', 'collection' => 'collec']);
  $this->assertEquals(['id' => 'data', 'a' => 'value3', 'b' => 'value4'], $r['data']['data']);
}

}

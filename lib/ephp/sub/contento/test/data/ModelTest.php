<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../../include.php');

class ModelTest extends TestCase {

static public $db;
static public $model;

public static  function setUpBeforeClass() {
  self::$db = new \contento\data\Db();
  self::$model = new \contento\data\Model();
  self::$model->db = self::$db;
}

public function setUp() {
  self::$db->pdo = \ephp\db\Db::sqlite(':memory:');
  self::$db->create();
}


public function testCollectionAddOk() {
  self::$model->collection_add(['name' => 'collec']);
 
  $this->assertEquals(['name' => 'collec', 'data' => ['name' => 'collec']], self::$model->collection_by_name('collec'));
}

public function testCollectionFromTypeAddOk() {
  self::$model->collection_add([
    'name' => 'collec',
    'type' => 'collection',
    'id' => ['a'],
    'elem' => [
       'type' => 'object',
       'fields' => [
         ['field' => 'a', 'type' => 'string'],
         ['field' => 'b', 'type' => 'string']
       ]
     ]
    ]
  );

  $this->assertEquals(['name' => 'collec', 'data' =>[
     'name' => 'collec', 
     'type' => 'collection',
     'id' => ['a'],
     'elem' => [
       'type' => 'object',
       'fields' => [
         ['field' => 'a', 'type' => 'string'],
         ['field' => 'b', 'type' => 'string']
       ]
     ]
    ]], self::$model->collection_by_name('collec'));
}

public function testCollectionFromTypeCustomOk() {
  self::$model->collection_add(
  ['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
   ]
  ]);

  
  $this->assertEquals([
    'name' => 'collec',
    'type' => 'collection',
    'elem' => [
      'type' => 'object',
      'fields' => [['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
  ]], self::$model->collection_by_name('collec')['data']);

  $this->assertEquals([
    'type' => 'object',
    'fields' => [['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string'] ]
  ], self::$model->get_type('collec')->data);

}

public function testDataAdd() {
  self::$model->collection_add(
  ['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'id', 'type' => 'id'], ['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
   ]
  ]);

  self::$model->data_add(['a' => 'aaa', 'b' => 'bbb'], 'collec');
  
  $data = self::$model->data_by_collection('collec', false)[0];
 
  $this->assertEquals('aaa', $data['data']['a']);
  $this->assertEquals('bbb', $data['data']['b']);
  $this->assertEquals(0, strpos('id-generated', $data['data']['id']));

}

public function testDataAddRepeated() {
  self::$model->collection_add(
  ['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'id', 'type' => 'id'], ['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
   ]
  ]);

  self::$model->data_add(['id' => 'i', 'a' => 'a1', 'b' => 'b1'], 'collec');

  $this->assertEquals('i-2',self::$model->get_existant_id('i', 'collec'));

  $this->assertTrue(self::$model->data_exists('i', 'collec'));

  self::$model->data_add(['id' => 'i', 'a' => 'a2', 'b' => 'b2'], 'collec');

  $data = self::$model->data_by_name_collection('i-2', 'collec', false);
  
  $this->assertEquals(['id' => 'i-2', 'a' => 'a2', 'b' => 'b2'], $data['data']);
}

public function testDataUpdate() {
  self::$model->collection_add(
  ['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'id', 'type' => 'id'], ['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
   ]
  ]);

  self::$model->data_add(['a' => 'aaa', 'b' => 'bbb'], 'collec');

  $data = self::$model->data_by_collection('collec', false)[0]['data'];

  $old_id = $data['id'];
  
  $this->assertEquals(0, strpos('id-generated', $old_id));

  $data['id'] = 'iii';
  self::$model->data_update($data, $old_id, 'collec');

  $data = self::$model->data_by_collection('collec', false)[0];

  $this->assertEquals(['id' => 'iii', 'a' => 'aaa', 'b' => 'bbb'], $data['data']);
}

public function testDataUpdateRef() {
  self::$model->collection_add(
  ['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'id', 'type' => 'id'], ['field' => 'r', 'type' => 'ref', 'collection' => 'collec']]
   ]
  ]);

  self::$model->data_add(['id' => 'i1'], 'collec');
  self::$model->data_add(['id' => 'i2', 'r' => 'i1'], 'collec');

  $data1 = self::$model->data_by_name_collection('i1', 'collec', false)['data'];
  $data2 = self::$model->data_by_name_collection('i2', 'collec', false)['data'];

  $this->assertEquals(['id' => 'i1'], $data1);
  $this->assertEquals(['id' => 'i2', 'r' => 'i1'], $data2);

  self::$model->data_update(['id' => 'i3'], 'i1', 'collec');

  $data1 = self::$model->data_by_name_collection('i3', 'collec', false)['data'];
  $data2 = self::$model->data_by_name_collection('i2', 'collec', false)['data'];

  $this->assertEquals(['id' => 'i3'], $data1);
  $this->assertEquals(['id' => 'i2', 'r' => 'i3'], $data2);
}


}

<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../../include.php');

class ImageModelTest extends TestCase {

static public $db;
static public $model;

public static  function setUpBeforeClass() {
  self::$db = new \contento\image\Db();
  self::$model = new \contento\image\Model();
  self::$model->db = self::$db;
  self::$model->file_dir = '/tmp/test/contento';
}

public function setUp() {
  self::$db->pdo = \ephp\db\Db::sqlite(':memory:');
  self::$db->create();
}

public function testImageAdd() {
  $test_file = __DIR__ . '/files/image.jpg';

  $data = self::$model->image_add([
    'type' => mime_content_type($test_file),
    'tmp_name' => $test_file
  ], 'some_description', []);

  $id = $data['id'];

  $r = self::$model->image_by_id($id);
  $this->assertFileEquals($test_file, $r['filename']);

  $old_date = $r['time'];
  $new_size = ['hola' => 'adfadsf'];

  usleep(1500000);
  self::$model->image_update_by_id($id, '', $new_size);

  $r = self::$model->image_by_id($id);
  $this->assertFileEquals($test_file, $r['filename']);
  $this->assertGreaterThan($old_date, $r['time']);
  $this->assertEquals($new_size, $r['sizes']);
} 

public function testImageBy() {
  $test_file = __DIR__ . '/files/image.jpg';

  $id = self::$model->image_add([
    'type' => mime_content_type($test_file),
    'tmp_name' => $test_file
  ], 'some_description', []);

  $r = self::$model->image_by();

  $this->assertEquals($r[0]['description'], 'some_description');
}



}

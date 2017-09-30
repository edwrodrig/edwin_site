<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');


class ErrorTest extends TestCase {

function testNoOffset() {
  $m = new class extends \ephp\Error {
  
    const ERR = [
      'code 1',
      'code 2'
    ];
  };


  $fired;

  try {
    $fired = false;
    $m->fire('code 1');
  } catch ( \Exception $e ) {
    $this->assertEquals(1, $e->getCode());
    $this->assertEquals('code 1', $e->getMessage());
    $this->assertEquals('', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);

  try {
    $fired = false;
    $m->fire('code 2', 'some description');
  } catch ( \Exception $e ) {
    $this->assertEquals(2, $e->getCode());
    $this->assertEquals('code 2', $e->getMessage());
    $this->assertEquals('some description', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);

  try {
    $fired = false;
    $m->fire('code 3', 'some description 2');
  } catch ( \Exception $e ) {
    $this->assertEquals(0, $e->getCode());
    $this->assertEquals('code 3', $e->getMessage());
    $this->assertEquals('some description 2', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);
}

function testOffset() {
  $m = new class extends \ephp\Error {

    const ERR = [
      8000,
      'code 1',
      'code 2'
    ];
  };

  try {
    $fired = false;
    $m->fire('code 1');
  } catch ( \Exception $e ) {
    $this->assertEquals(8001, $e->getCode());
    $this->assertEquals('code 1', $e->getMessage());
    $this->assertEquals('', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);

  try {
    $fired = false;
    $m->fire('code 2', 'some description');
  } catch ( \Exception $e ) {
    $this->assertEquals(8002, $e->getCode());
    $this->assertEquals('code 2', $e->getMessage());
    $this->assertEquals('some description', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);

  try {
    $fired = false;
    $m->fire('code 3', 'some description 2');
  } catch ( \Exception $e ) {
    $this->assertEquals(8000, $e->getCode());
    $this->assertEquals('code 3', $e->getMessage());
    $this->assertEquals('some description 2', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);
}


}

<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\ResponseAssoc;

class ResponseAssocTest extends TestCase {

function testAction() {
  $r = new ResponseAssoc;
  $r->request = new class { function __invoke($arg) { return $arg; } };
  $this->assertEquals(['status' => 0, 'data' => 'hola'], $r('hola'));
}

function testException() {
  $r = new ResponseAssoc;
  $r->request = new class { function __invoke($arg) { throw new \Exception($arg, 100); } };

  $this->assertEquals(['status' => -1, 'code' => 100, 'message' => 'hola'], $r('hola'));
}

function testTraitErrorException() {
  $r = new ResponseAssoc;
  $r->request = new class {
    function __invoke($arg) {
      $e = new \Exception($arg, 100);
      $e->desc = 'description';
      throw $e;
    }
  };

  $this->assertEquals(['status' => -1, 'code' => 100, 'message' => 'hola', 'description' => 'description'], $r('hola'));
}

}



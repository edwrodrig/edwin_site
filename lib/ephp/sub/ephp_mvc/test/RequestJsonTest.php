<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\RequestJson;

class RequestJsonTest extends TestCase {

function testNoAction() {
  try {
    (new RequestJson)('');
    $this->assertTrue(false);
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_SPECIFIED', $e->getMessage());
  }
}

function testNoActionSpecified() {
  try { 
    $c = new RequestJson;
    $c->add_action(new class{});
    $c('[]');

    $this->assertTrue(false);
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_SPECIFIED', $e->getMessage());
  }
} 

function testInvalidInput() {
  try {
    $c = new RequestJson;
    $c->add_action(new class{});
    $c('dgadgag');

    $this->assertTrue(false);
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_SPECIFIED', $e->getMessage());
  }
}

function testActionNotExists() {
  try {
    $c = new RequestJson;
    $c->add_action(new class {});

    $c('{"action": "test"}');
    
    $this->assertTrue(false);
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_AVAILABLE', $e->getMessage());
  }

}

function testActionParamMissing() {
  try {
    $c = new RequestJson;
    $c->add_action(new class {
      function test($str1, $str2 = 'string') { return $str1 . $str2;}
    });

    $c('{"action": "test"}');

    $this->assertTrue(false);
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_PARAM_MISSING', $e->getMessage());
    $this->assertEquals('str1', $e->desc);
  }

}


function testActionCall () {
  $c = new RequestJson;
  $c->add_action(new class {
    function test() { return 'hola';}
  });

  $this->assertEquals('hola', $c('{"action": "test"}'));
}

function testActionCallParam () {
  $c = new RequestJson;
  $c->add_action(new class {
    function test($str1, $str2 = 'string') { return $str1 . $str2;} 
  });

  $this->assertEquals('ss1ss2', $c('{"action": "test", "str1": "ss1","str2": "ss2"}'));

  $this->assertEquals('ss1string', $c('{"action":"test", "str1": "ss1"}'));
}


}

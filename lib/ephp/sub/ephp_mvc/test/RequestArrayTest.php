<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\RequestArray;

class RequestArrayTest extends TestCase {

function testNoAction() {
  $this->expectException(\Exception::class);
  $this->expectExceptionMessage('ACTION_NOT_SPECIFIED');
  (new RequestArray)(null);
}

function testNoActionSpecified() {
  $this->expectException(\Exception::class);
  $this->expectExceptionMessage('ACTION_NOT_SPECIFIED');

  $c = new RequestArray;
  $c->add_action(new class{});
  $c([]);
} 

function testInvalidInput() {
  $this->expectException(\Exception::class);
  $this->expectExceptionMessage('ACTION_NOT_SPECIFIED');

  $c = new RequestArray();
  $c->add_action(new class{});
  $c('%$2$%@$@25$');

}

function testActionNotExists() {
  $this->expectException(\Exception::class);
  $this->expectExceptionMessage('ACTION_NOT_AVAILABLE');
  $c = new RequestArray();
  $c->add_action(new class {});

  $c(['hola']);
}

function testActionParamMissing() {
  $fired = false;
  try {
    $c = new RequestArray();
    $c->add_action(new class {
      function test($str1, $str2 = 'string') { return $str1 . $str2;}
    });

    $c(['test']);

  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_PARAM_MISSING', $e->getMessage());
    $this->assertEquals('str1', $e->desc);
    $fired = true;
  }
  $this->assertTrue($fired);

}


function testActionCall () {
  $c = new RequestArray();
  $c->add_action(new class {
    function test() { return 'hola';}
  });

  $this->assertEquals('hola', $c(["test"]));
}

function testActionCallParam () {
  $c = new RequestArray;
  $c->add_action(new class {
    function test($str1, $str2 = 'string') { return $str1 . $str2;} 
  });

  $this->assertEquals('ss1ss2', $c(["test", "ss1", "ss2"]));

  $this->assertEquals('ss1string', $c(["test", "ss1"]));
}


}

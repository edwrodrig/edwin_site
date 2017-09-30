<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use \ephp\mvc\RequestConsole;

class RequestConsoleTest extends TestCase {

function testInvalidFormat() {
  ob_start();
  (new RequestConsole)('dlfaldf');
  $this->assertEquals("Available commands:\n  help                                 Show help\n\n", ob_get_clean());

}

function testNoAction() {
  ob_start();
  (new RequestConsole)([]);
  $this->assertEquals("Available commands:\n  help                                 Show help\n\n", ob_get_clean());
}

function testActionNotExists() {
  ob_start();
  (new RequestConsole)(['test']);
  $this->assertEquals("Available commands:\n  help                                 Show help\n\n", ob_get_clean());
}

function testActionCall () {
  $c = new RequestConsole;
  $c->add_action(new class {
    function test() { echo 'hola';}
  });

  ob_start();
  $c(['test']);
  $this->assertEquals('hola', ob_get_clean());
}

function testActionCallParam () {
  $c = new RequestConsole;
  $c->add_action(new class {
    function test($str1, $str2 = 'string') { echo $str1, $str2;}
  });

  ob_start();
  $c(['test', 'ss1', 'ss2']);
  $this->assertEquals('ss1ss2', ob_get_clean());

  ob_start();
  $c(['test', 'ss1']);
  $this->assertEquals('ss1string', ob_get_clean());

  ob_start();
  $c(['test']);
  $this->assertEquals("Error:\nACTION_PARAM_MISSING\n", ob_get_clean());
}

}


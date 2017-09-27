<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use \ephp\mvc\ActionHelp;

class ActionHelpTest extends TestCase {

function invokeMethod($obj, $method, ...$args) {
  $class = new \ReflectionClass($obj);
  $method = $class->getMethod($method);
  $method->setAccessible(true);
  return $method->invokeArgs(null, $args);

}

function testCommentWithParams() {
  $comment = <<<EOL
/*
  * @desc description 1 2 ab
  * @param p1 description 1
  * @param p2 description 2
  * Hola
  * hola como te va
  * yeah
*/
EOL;

  $this->assertEquals(
    ['desc' => 'description 1 2 ab', 'params' => ['p1' => 'description 1', 'p2' => 'description 2'], 'content' => "Hola\nhola como te va\nyeah",],
    $this->invokeMethod('\ephp\mvc\ActionHelp', 'comment', $comment)
  );

}

function testCommentWithoutParams() {
  $comment = <<<EOL
/*
  * Hola
  * hola como te va
  * yeah
*/
EOL;
  $this->assertEquals(
    ['params' => [], 'content' => "Hola\nhola como te va\nyeah"],
    $this->invokeMethod('\ephp\mvc\ActionHelp', 'comment', $comment)
  );

}

function testCommentWithoutParams2() {
  $comment = <<<EOL
/**
  * EPHP
  * test
  */
EOL;
  $this->assertEquals(
    ['params' => [], 'content' => "EPHP\ntest"],
    $this->invokeMethod('\ephp\mvc\ActionHelp', 'comment', $comment)
  );

}

function testHelp() {
  $request = new \ephp\mvc\Request;
  $help = new ActionHelp;
  $help->request = $request;

  $request->add_action(
    $help,
    /**
    * EPHP
    * test
    */
    new class {}
  );
  
  $out = "EPHP\ntest\n\nAvailable commands:\n  help                                 Show help\n\n";

  ob_start();
  $request->invoke_action('help', []);
  $this->assertEquals($out, ob_get_clean()); 
}

function testHelpCommand() {
  $request = new \ephp\mvc\Request;
  $help = new ActionHelp;
  $help->request = $request;

  $request->add_action(
    $help,
    new class {
      /**
      * @desc Test method
      * @param arg1 argument 1
      * @param arg2 argument 2
      * Other info
      *   some description
      */
      function test($arg1, $arg2 = 'value') {}
    }
  );

  ob_start();
  $request->invoke_action('help', ['test']);
  $this->assertEquals("test\nTest method\n\nParameters:\n  arg1                                 argument 1\n  arg2                                 argument 2 (default: value)\n\nInformation:\nOther info\n  some description\n", ob_get_clean());

}

}

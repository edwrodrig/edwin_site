<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\Loader;

class LoaderTest extends TestCase {

/**
 * @runInSeparateProcess
 */
function testLoaderJsonNoAction() {
  $l = new class extends Loader {
    function http() {
      $this->request->add_action(new class {
        function sum($a, $b) { return $a + $b; }
      });
    }
  };
  
  $l->set_config([
    'console_enabled' => false,
    'error_logging_enabled' => false
  ]);

  ob_start();
  $l();
  $result = ob_get_clean();

  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Content-Type: application/json; charset=utf-8'
  ], xdebug_get_headers());

  $this->assertEquals('{"status":-1,"code":101,"message":"ACTION_NOT_SPECIFIED","description":""}', $result);
}

/**
 * @runInSeparateProcess
 */
function testLoaderPostAction() {
  $l = new class extends Loader {
    function http() {
      $this->request->add_action(new class {
        function sum($a, $b) { return $a + $b; }
      });
    }
  };

  $l->set_config([
    'console_enabled' => false,
    'error_logging_enabled' => false
  ]);

  $_GET['action'] = 'sum';
  $_GET['a'] = 2;
  $_GET['b'] = 4;

  ob_start();
  $l();
  $result = ob_get_clean();

  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Content-Type: application/json; charset=utf-8'
  ], xdebug_get_headers());

  $this->assertEquals('{"status":0,"data":6}', $result);
}



}



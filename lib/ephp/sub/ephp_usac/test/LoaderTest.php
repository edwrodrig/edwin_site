<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class LoaderTest extends TestCase {

/**
 * @runInSeparateProcess
 */
function testLoaderPostAction() {
  $l = new \ephp\usac\Loader();

  $l->set_config([
    'usac' => [
      'user_login_guest_enabled' => false,
      'db' => ':memory:'
    ],
    'console_enabled' => false,
    'error_logging_enabled' => false
  ]);

  
  $_GET['action'] = 'user_login_guest';
  ob_start();
  $l();
  $result = ob_get_clean();
  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Content-Type: application/json; charset=utf-8'
  ], xdebug_get_headers());
  $this->assertEquals('{"status":-1,"code":102,"message":"ACTION_NOT_AVAILABLE","description":""}', $result);
}


}

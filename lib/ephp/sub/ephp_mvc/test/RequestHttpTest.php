<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\RequestHttp;

class RequestHttpTest extends TestCase {

/**
 * @runInSeparateProcess
 */
function testActionGet() {
  $r = new RequestHttp;
  $r->add_action(new class {
    function action() { return 'result'; }
  });

  $_GET['action'] = 'action';
  
  $r();

  $this->assertEquals('result', $r());
}

/**
 * @runInSeparateProcess
 */
function testActionPost() {
  $r = new RequestHttp;
  $r->default_input = '/tmp/temp_file';
  $r->add_action(new class {
    function action() { return 'result'; }
  });

  file_put_contents($r->default_input, '{"action" : "action"}');

  $r();

  $this->assertEquals('result', $r());
}

}



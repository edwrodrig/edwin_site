<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\ResponseHttp;

class ResponseHttpTest extends TestCase {

/**
 * @runInSeparateProcess
 */
function testResponseJson() {
  $r = new ResponseHttp;
  $r->request = new class { function __invoke($arg) { return $arg; } };

  ob_start();
  $r('hola');
  $result = ob_get_clean();

  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Content-Type: application/json; charset=utf-8'
  ], xdebug_get_headers());

  $this->assertEquals('{"status":0,"data":"hola"}', $result);
}

/**
 * @runInSeparateProcess
 */
function testResponseFileData() {
  $r = new ResponseHttp;
  $r->request = new class { function __invoke($arg) { return $arg; } };

  ob_start();
  $r([
    '__response_type' => 'file',
    'name' => 'text.txt',
    'data' => 'HOLACOMOTEVA',
    'type' => 'text/other'
  ]);
  $result = ob_get_clean();

  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Cache-Control: public',
    'Content-type: text/other;charset=UTF-8',
    'Content-Transfer-Encoding: Binary',
    'Content-Length:12',
    'Content-Disposition: attachment; filename=text.txt'
  ], xdebug_get_headers());

  $this->assertEquals('HOLACOMOTEVA', $result);
}

/**
 * @runInSeparateProcess
 */
function testResponseFileData2() {
  $r = new ResponseHttp;
  $r->request = new class { function __invoke($arg) { return $arg; } };

  ob_start();
  $r([
    '__response_type' => 'file',
    'data' => 'HOLACOMOTEVA',
  ]);
  $result = ob_get_clean();

  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Cache-Control: public',
    'Content-type: text/plain;charset=UTF-8',
    'Content-Transfer-Encoding: Binary',
    'Content-Length:12',
    'Content-Disposition: attachment; filename=data.txt'
  ], xdebug_get_headers());

  $this->assertEquals('HOLACOMOTEVA', $result);
}

/**
 * @runInSeparateProcess
 */
function testResponseFileName() {
  $r = new ResponseHttp;
  $r->request = new class { function __invoke($arg) { return $arg; } };

  $testfile = __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'test.txt';

  ob_start();
  $r([
    '__response_type' => 'file',
    'filename' => $testfile
  ]);
  $result = ob_get_clean();

  $this->assertEquals([
    'Access-Control-Allow-Origin: *',
    'Cache-Control: public',
    'Content-type: text/plain;charset=UTF-8',
    'Content-Transfer-Encoding: Binary',
    'Content-Length:8',
    'Content-Disposition: attachment; filename=test.txt'
  ], xdebug_get_headers());

  $this->assertEquals("SOMEDATA", $result);
}


}



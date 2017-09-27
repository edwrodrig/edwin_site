<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\web\DefineGuard;

class DefineGuardTest extends TestCase {

function setUp() {
  ephp\web\DefineGuard::reset();
}

function testDefineStyle() {
  $static_func = function() {
    static $i = 0;
    return $i++;
  };

  $s = function() use($static_func) {
    return DefineGuard::define(function() use($static_func) { return ($static_func)(); });
  };

  $this->assertEquals(0, $static_func());
  $this->assertEquals(1, $static_func());
  
  $this->assertEquals(2, $s());
  $this->assertEquals(2, $s());
  $this->assertEquals(3, $static_func());
  return $this->assertEquals(1000, DefineGuard::define(function() { return 1000;}));
  $this->assertEquals(2, $s());
  $this->assertEquals(4, $static_func());

  
}

}


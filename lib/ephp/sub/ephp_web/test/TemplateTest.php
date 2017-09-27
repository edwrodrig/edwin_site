<?php
require_once(__DIR__ . '/../include.php');

use PHPUnit\Framework\TestCase;


class A extends ephp\web\Template {

function p1($content) { echo 'A_' , $content , '_A'; }
function p2($content) { echo 'A_' , $content , '_A';}
function p3($content) { echo 'A_' , $content , '_A';}
function p6($content) { echo 'A_' , $content , '_A';}
}

class B extends A {

function p1($content) { echo "B_" , $content , "_B"; }
function p4($content) { echo "B_" , $content , "_B"; }
function p6($content) { echo 'B_' , $content , "_B"; }
function p7($content) { echo 'B_' , $content , '_B'; }
}

class C extends B {

function p1($content) { echo "C_" , $content , "_C"; }
function p2($content) { echo "C_" , $content , "_C"; }
function p5($content) { echo "C_" , $content , "_C"; }
function p7($content) { echo 'C_' , $content , '_C'; }
}


class TemplateTest extends TestCase {

function testTemplateBaseDefault() {
  ob_start();
  (new C)->bottom_up_call('p1');
  $this->assertEquals("A_B_C__C_B_A", ob_get_clean());
}

function testTemplateBaseHole() {
  ob_start();
  (new C)->bottom_up_call('p2');
  $this->assertEquals("A_C__C_A", ob_get_clean());

  ob_start();
  (new C)->bottom_up_call('p6');
  $this->assertEquals("A_B__B_A", ob_get_clean());

  ob_start();
  (new C)->bottom_up_call('p7');
  $this->assertEquals("B_C__C_B",  ob_get_clean());
}

function testTemplateBaseUnique() {
  ob_start();
  (new C)->bottom_up_call('p3');
  $this->assertEquals("A__A", ob_get_clean());

  ob_start();
  (new C)->bottom_up_call('p4');
  $this->assertEquals("B__B", ob_get_clean());

  ob_start();
  (new C)->bottom_up_call('p5');
  $this->assertEquals("C__C", ob_get_clean());
}

function testTemplateDynamicFunction() {
  ob_start();
  $c = (new C);
  $c->template_content['p1'] = function() { echo 'D'; };
  $c->bottom_up_call('p1');
  $this->assertEquals('A_B_C_D_C_B_A', ob_get_clean());

  ob_start();
  $c = (new C);
  $c->template_content['p2'] = function() { echo 'D'; };
  $c->bottom_up_call('p2');
  $this->assertEquals('A_C_D_C_A', ob_get_clean());

  ob_Start();
  $c = (new C);
  $c->template_content['p8'] = function() { echo 'D'; };
  $c->bottom_up_call('p8');
  $this->assertEquals('D', ob_get_clean());
}

function testTemplateToString() {
  $c = new class extends ephp\web\Template {
    function print() {
      throw new \Exception('exception');
    }
  };

  $this->assertEquals('', strval($c));
  
}

}


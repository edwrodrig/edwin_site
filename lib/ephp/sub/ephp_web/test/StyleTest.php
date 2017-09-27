<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\web\Style;

class StyleTest extends TestCase {

function setUp() {
  ephp\web\BuilderState::push();
}

function tearDown() {
  ephp\web\BuilderState::pop();
}

function testAnonimo() {
  $s = new Style(['color' => 'white']);
  $this->assertEquals('color:white;', strval($s));
}

function testSelector() {
  $s = new Style('#id', ['color' => 'white']);
  $this->assertEquals('#id{color:white;}', strval($s));
}

function testEmpty() {
  $s = new Style();
  $this->assertEquals('', strval($s));
}

function testSelectorEmpty() {
  $s = new Style('#id');
  $this->assertEquals('', strval($s));
}

function testMultipleArray() {
  $s = new Style(['color' => 'white', 'background-color' => 'black']);
  $this->assertEquals('color:white;background-color:black;', strval($s));
}

function testStyleParam() {
  $s = new Style(style(['color' => 'white']));
  $this->assertEquals('color:white;', strval($s));  
}

function testStyleParamIgnoreSelector() {
  $b = new Style('#base', ['color' => 'white', 'background-color' => 'red']);
  $d = new Style('#derived', $b, ['background-color' => 'black']);
  
  $this->assertEquals('#base{color:white;background-color:red;}', strval($b));
  $this->assertEquals('#derived{color:white;background-color:black;}', strval($d));
}

function testStyleParamConsiderSelectorInArray() {
  $s = new Style('#id', ['color' => 'black', ':hover' => ['color' => 'white']]);
  $this->assertEquals('#id{color:black;}#id:hover{color:white;}', strval($s));
}

function testStyleParamConsiderSelectorInArray2() {
  $s = new Style('#id', ['color' => 'black', ':hover' => ['color' => 'white']]);
  $this->assertEquals('#id{color:black;}#id:hover{color:white;}', strval($s));
}


function testUnsetParam() {
  $s = new Style(['color' => 'black', 'background-color' => 'white'], ['background-color' => null]);
  $this->assertEquals('color:black;', strval($s));
}

function testUnsetStyle() {
  $s = new Style(['color' => 'black', ':hover' => style(['background-color' => 'white'])], [':hover' => null]);
  $this->assertEquals('color:black;', strval($s));
}

function testStyleParamWithSubStyle() {
  $s = new Style('#id', style([':hover' => style(['color' => 'white'])]), ['color' =>'red']);
  $this->assertEquals('#id{color:red;}#id:hover{color:white;}', strval($s));
}

function testStyleSubStyleReplace() {
  $s = new Style('#id', ['color' => 'red'], style([':hover' => style(['color' => 'white'])]), [':hover' => style(['background-color' => 'black'])]);
  $this->assertEquals('#id{color:red;}#id:hover{color:white;background-color:black;}', strval($s));
}

function testStyleSubStyleReplace2() {
  $s = new Style('#id', ['color' => 'red'], [':hover' => ['color' => 'white']], [':hover' => ['background-color' => 'black']]);
  $this->assertEquals('#id{color:red;}#id:hover{color:white;background-color:black;}', strval($s));
}


function testIdGenerator() {
  $s = new Style('#');
  $this->assertEquals('#t0', $s->selector);
  $s = new Style('#');
  $this->assertEquals('#t1', $s->selector);
}

function testClassGenerator() {
  $s = new Style('.');
  $this->assertEquals('.s0', $s->selector);
  $s = new Style('.');
  $this->assertEquals('.s1', $s->selector);
}

function testForceAnon() {
  $s = new Style(new Style(), new Style('#id', ['color' => 'red']));
  $this->assertEquals('color:red;', strval($s));

  $s = new Style($s, new Style('#id', ['background-color' => 'red', ':hover' => ['color' => 'blue']]));
  $this->assertEquals('color:red;background-color:red;', strval($s));
}

function testIssetAnon() {
  $this->assertEquals((new Style())->isset(), false, 'empty style');
  $this->assertEquals((new Style(['color' => 'red']))->isset(), true, 'not empty');
  $this->assertEquals((new Style([':hover' => ['color' => 'red']]))->isset(), false, 'sub style');
}

function testPrint() {
  ob_start();
  $s = style('#a', ['color' => 'red']);
  $this->assertEquals('#a{color:red;}', ob_get_clean());
  
  ob_start();
  $s->print();
  $this->assertEquals('', ob_get_clean());

}

function testClassStr() {
  $s = new Style('.clase');
  $this->assertEquals('clase', $s->class_str());
}

function testStyleSubStyleChild() {
  $s = new Style('.a', ['color' => 'red', '> *' => ['color' => 'blue']]);
  $this->assertEquals(".a{color:red;}.a > *{color:blue;}", strval($s));

}

function testStyleSubStyleChild2() {
  $s = new Style('a', ['color' => 'red', '> *' => ['color' => 'blue']]);
  $this->assertEquals("a{color:red;}a > *{color:blue;}", strval($s));
}


function testStyleMedia() {
  $s = new Style('.a', ['color' => 'red', '@media' => ['color' => 'blue']]);
  $this->assertEquals('.a{color:red;}@media{.a{color:blue;}}', strval($s));
}

function testStyleMediaNested() {
  $s = new Style('.a', ['color' => 'red', '@media' => ['color' => 'blue'], ':hover' => ['@media' => ['color' => 'yellow']]]);
  $this->assertEquals('.a{color:red;}@media{.a{color:blue;}}@media{.a:hover{color:yellow;}}', strval($s));
}

function testStyleMediaWithNested() {
  $s = new Style('.a', ['@media' => [':hover' => ['color' => 'yellow']]]);
  $this->assertEquals('@media{.a:hover{color:yellow;}}', strval($s));
}


}


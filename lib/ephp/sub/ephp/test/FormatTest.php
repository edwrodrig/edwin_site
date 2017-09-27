<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\Format;

class FormatTest extends TestCase {

function tearDown() {
  setlocale(LC_ALL, 'en_US.utf-8');
}

function trProvider() {
  return [
['hola', 'hola'],
['hola', ['es' => 'hola', 'en' => 'hello']],
['hola', ['en' => 'hello', 'es' => 'hola']],
[['title' => 'hola', 'content' => 'algun contenido'],['title' => ['es' => 'hola', 'en' => 'hello'], 'content' => ['es' => 'algun contenido', 'en' => 'come content']]],
['hola', ['en' => 'hola']],
[['other' => 'hola'], [ 'other' => 'hola']],
[['a', 'b', 'c'], ['a', 'b', 'c']],
  ];
}

/**
 * @dataProvider trProvider
 */
function testTr($expected, $value) {
  $b = new \ephp\web\Builder;
  $b->lang = 'es';
  $this->assertEquals($expected, Format::tr($value));
}

function testDateEs() {
  setlocale(LC_ALL, 'es_CL.utf-8');
  
  $this->assertEquals('Viernes 11 de Diciembre de 2015', Format::date('2015-12-11'));
}

function testDateUs() {
  setlocale(LC_ALL, 'en_US.utf-8');

  $this->assertEquals('Monday, May 11, 2015', Format::date('2015-05-11'));
}

}


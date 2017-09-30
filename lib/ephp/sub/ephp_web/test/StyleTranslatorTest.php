<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\web\StyleTranslator;

class StyleTranslatorTest extends TestCase {

static function s($arg) { return (new StyleTranslator($arg))(); }

function testAnonimo() {
  $this->assertEquals('color:white;', self::s(['color' => 'white']));
}

function testLayout() {
  $this->assertEquals('display:flex;flex-direction:row;', self::s(['layout' => 'row']));
}

function testBgCover() {
  $this->assertEquals('background-size:cover;background-position:center;', self::s(['bg-cover' => 0]));
}

function testTrans() {
  $this->assertEquals('transition:background-color 0.5s color 0.5s;', self::s(['trans' => ['background-color' => '0.5s', 'color' => '0.5s']]));
}

}


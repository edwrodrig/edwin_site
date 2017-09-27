<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\web\Builder;

class BuilderTest extends TestCase {

function testTrString() {
  $b = new Builder();
  $b->lang = 'es';
  $this->assertEquals('es', $b->lang());
}

function testTrStringEn() {
  $b = new Builder();
  $b->lang = 'en';
  $this->assertEquals('en', $b->lang());
}

function urlNoneProvider() {
  return [
    ['hola.html', 'hola.html'],
    ['/hola.html', '/hola.html'],
    ['//hola.html', '//hola.html'],
    ['http://hola.html', 'http://hola.html'],
    ['https://hola.html', 'https://hola.html'],
    ['   hola.html   ', 'hola.html'],
    ['   /hola.html   ', '/hola.html'],
    ['   https://hola.html   ', 'https://hola.html']
  ];
}

/**
 * @dataProvider urlNoneProvider
 */
function testUrlNoneDefault($url, $expected) {
  $b = new Builder();
  $this->assertEquals($expected, url($url));
}

/**
 * @dataProvider urlNoneProvider
 */
function testUrlNoneEmpty($url, $expected) {
  $b = new Builder();
  $b->base_url = '';
  $this->assertEquals($expected, url($url));
}

/**
 * @dataProvider urlNoneProvider
 */
function testUrlNoneEmptyTrim($url, $expected) {
  $b = new Builder();
  $b->base_url = '   ';
  $this->assertEquals($expected, url($url));
}


/**
 * @dataProvider urlNoneProvider
 */
function testUrlNoneNull($url, $expected) {
  $b = new Builder();
  $b->base_url = null;
  $this->assertEquals($expected, url($url));
}

function urlSomeProvider() {
  return [
    ['hola.html', 'hola.html'],
    ['/hola.html', 'http://www.new.cl/hola.html'],
    ['//hola.html', '//hola.html'],
    ['http://hola.html', 'http://hola.html'],
    ['https://hola.html', 'https://hola.html'],
    ['   hola.html   ', 'hola.html'],
    ['   /hola.html   ', 'http://www.new.cl/hola.html'],
    ['   https://hola.html   ', 'https://hola.html']
  ];
}

/**
 * @dataProvider urlSomeProvider
 */
function testUrlSomeGood($url, $expected) {
  $b = new Builder();
  $b->base_url = 'http://www.new.cl';
  $this->assertEquals($expected, url($url));
}

/**
 * @dataProvider urlSomeProvider
 */
function testUrlSomeTrailing($url, $expected) {
  $b = new Builder();
  $b->base_url = 'http://www.new.cl/';
  $this->assertEquals($expected, url($url));
}

/**
 * @dataProvider urlSomeProvider
 */
function testUrlSomeTrim($url, $expected) {
  $b = new Builder();
  $b->base_url = '   http://www.new.cl  ';
  $this->assertEquals($expected, url($url));
}

/**
 * @dataProvider urlSomeProvider
 */
function testUrlSomeTrimTrail($url, $expected) {
  $b = new Builder();
  $b->base_url = '   http://www.new.cl/   ';
  $this->assertEquals($expected, url($url));
}


}


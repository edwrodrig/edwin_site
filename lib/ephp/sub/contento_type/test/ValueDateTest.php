<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ValueDateTest extends TestCase {

function valueProvider() {
  return [
    [[], '2017-01-01', '2017-01-01'],
    [[], '  2017-01-01 ', '2017-01-01'],
    [[],  ' ', null],
    [['default' => '2017-05-22'], '', '2017-05-22'],
    [['default' => '2017-05-22'], null, '2017-05-22'],
    [['default' => '2017-05-22'], '2017-07-21', '2017-07-21']
  ];
}

/**
 * @dataProvider valueProvider
 */
function testValue($type, $value, $expected) {
  $type = new \contento\TypeDate($type);
  $this->assertEquals($expected, ($type)($value)());
}

function testValueNowDefault() {
  $type = new \contento\TypeDate(['default' => 'now']);
  
  $date = ($type)(null)();
  $this->assertEquals(0, (new DateTime())->diff(DateTime::createFromFormat('Y-m-d' , $date))->days);
}

function testValueNow() {
  $type = new \contento\TypeDate([]);

  $date = ($type)('now')();
  $this->assertEquals(0, (new DateTime())->diff(DateTime::createFromFormat('Y-m-d' , $date))->days);
}




function validateProvider() {
  return [
    ['', true],
    [null, true],
    ['2017', false],
    ['2017-00-00', false],
    ['2017-00-01', false],
    ['2017-1-1', false],
    ['2017-01-01', true]
  ];
}



/**
 * @dataProvider validateProvider  
 */
function testValidate($value, $success) {
  if ( !$success ) {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('DATE_INVALID');
  }
  
  $type = new \contento\TypeDate([]);
  $type($value)();
}

}

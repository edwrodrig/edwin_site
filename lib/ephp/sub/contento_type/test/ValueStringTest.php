<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ValueStringTest extends TestCase {


function valueProvider() {
  return [
    [[ 'trim' => false], ' hola ', ' hola '],
    [[], ' hola ', ' hola '],
    [['trim' => true], ' hola ', 'hola'],
    [['tr' => true], ['es' => ' espa ', 'en' => ' eng '], ['es' => ' espa ', 'en' => ' eng ']],
    [['tr' => true, 'trim' => true], ['es' => ' espa ', 'en' => ' eng '], ['es' => 'espa', 'en' => 'eng']],
    [[], null, null],
    [[], '', null],
    [['default' => 'hola'] , '', 'hola'],
    [['default' => 'hola'] , null, 'hola'],
    [['default' => 'hola'] , 'chao', 'chao']
  ];
}

/**
 * @dataProvider valueProvider
 */
function testValue($type, $value, $expected) {
  $type = new \contento\TypeString($type);
  $this->assertEquals($expected, ($type)($value)());
}

function validateProvider() {
  return [
    [[ 'validator' => '/\d\d\d/'], '234', true],
    [[ 'validator' => '/\d\d\d/'], '23', false],
    [[ 'validator' => '/\d\d\d/'], '2345', true],
    [[ 'validator' => '/^\d\d\d$/'], '2345', false],
    [[ 'validator' => '/^\d\d\d$/'], '234', true],
    [[], null, true]
  ];
}



/**
 * @dataProvider validateProvider  
 */
function testValidate($type, $value, $success) {
  if ( !$success ) $this->expectException(\Exception::class);
  
  $type = new \contento\TypeString($type);
  ($type)($value)();
}

}

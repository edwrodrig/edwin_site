<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ValueTest extends TestCase {


function valueProvider() {
  return [
    [['required' => true], 1, true],
    [['required' => true], null, false],
    [['required' => false], 1, true ],
    [['required' => false], null, true ],
    [[], 1, true ],
    [[], null, true]
  ];
}

/**
 * @dataProvider valueProvider
 */
function testValue($type, $value, $success) {
  if ( !$success ) $this->expectException(\Exception::class);
  $type = new \contento\Type($type);

  ($type)($value)();
}

}

<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../inc.php');

class ValueRefTest extends TestCase {

function updateRefProvider() {
  return [
    ['', ['c', '', 'hola'], true],
    [null, ['c', 'hola', 'chao'], false],
    ['hola', ['c', 'hola', 'chao'], true],
    ['hola', ['c', 'hola', 'hola'], false],
    ['hola', ['b', 'hola', 'chao'], false],
    [null, ['c', null, 'chao'], true],
    [null, ['b', null, 'chao'], false],
    [null, ['b', null, null], false]
  ];
}

/**
 * @dataProvider updateRefProvider
 */
function testUpdateRef($value, $args, $changed) {
  $type = \contento\Type::create(['type' => 'ref', 'collection' => 'c']);

  $v = $type($value);
  $this->assertEquals($value, $v());

  
  $this->assertEquals($changed, $v->update_ref(...$args));
  if ( $changed ) {
    $this->assertEquals($args[2], $v());
  } else {
    $this->assertEquals($value, $v());
  }
}

}

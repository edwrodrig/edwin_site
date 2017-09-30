<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ValueIdTest extends TestCase {


function idProvider() {
  return [
    ['aaa', 'aaa'],
    ['aAaAa----', 'aaaaa'],
    ['aA aAa----', 'aa-aaa']
  ];
}

/**
 * @dataProvider idProvider
 */
function testId($value, $expected) {
  $this->assertEquals($expected, \contento\Type::create(['type' => 'id'])($value)());
}

function testIdAuto() {
  $this->assertEquals(0, strpos(\contento\Type::create(['type' => 'id'])('-----'), 'id-generated' ));
}

function testAccent() {
  $this->assertEquals('aaaaaceeeeiiiinooooouuuuyyaaaaaceeeeiiiinooooouuuuy', \contento\Type::create(['type' => 'id'])('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ')());
}

}

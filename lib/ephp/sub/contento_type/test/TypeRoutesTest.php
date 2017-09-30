<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class TypeRoutesTest extends TestCase {

function routesProvider() {
  return [
[[
  'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id'],
    ['field' => 'a', 'type' => 'string']
  ]
],
['', 'id', 'a']],

[[
  'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id'],
    ['field' => 'a', 'type' => 'string'],
    ['field' => 'obj', 'type'=> 'object', 'fields' => [
      ['field' => 'a', 'type' => 'string'],
      ['field' => 'b', 'type' => 'string']
    ]]
  ]
],
['', 'id', 'a', 'obj', 'obj.a', 'obj.b']],

[[
  'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id'],
    ['field' => 'a', 'type' => 'string'],
    ['field' => 'obj', 'type'=> 'object', 'fields' => [
      ['field' => 'a', 'type' => 'string'],
      ['field' => 'b', 'type' => 'string']
    ]],
    ['field' => 'b', 'type' => 'string']
  ]
],
['', 'id', 'a', 'obj', 'obj.a', 'obj.b', 'b']],

[[
  'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id'],
    ['field' => 'a', 'type' => 'string'],
    ['field' => 'list', 'type' => 'list', 'elem' => [
      'type'=> 'object','fields' => [
        ['field' => 'a', 'type' => 'string'],
        ['field' => 'b', 'type' => 'string']
      ]
    ]],
    ['field' => 'b', 'type' => 'string']
  ]
],
['', 'id', 'a', 'list', 'list.elem', 'list.elem.a', 'list.elem.b', 'b']]



];

}

/**
 *  @dataProvider routesProvider
 */
function testRouter($type_data, $expected) {
  $type = \contento\Type::create($type_data);

  $this->assertEquals($expected, $type->routes());
}

}

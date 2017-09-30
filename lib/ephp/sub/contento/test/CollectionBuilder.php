<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use contento\CollectionBuilder as C;

class CollectionBuilderTest extends TestCase {

function testResolveTypeCustom() {
  $c = new C;
  $c->add(
[
  'name' => 'elements',
  'type' => 'collection',
  'elem' => [
    'name' => 'element',
    'type' => 'object' ,
    'fields' => [
      ['field' => 'a', 'type' => 'integer']
    ]
  ]
]);

  $this->assertEquals(['name' => 'elements', 'type' => 'collection', 'elem' => [ 'name' => 'element', 'type' => 'object', 'fields' => [
  ['field' => 'a', 'type' => 'integer'],
  ['field' => 'id', 'type' => 'id', 'display' => true, 'fields' => []]
]
]
], $c->resolve_type($c->collections['elements']));
  
}

function testResolveTypeCustom2() {
  $c = new C;
  $c->add(
[
  'name' => 'elements',
  'type' => 'collection',
  'elem' => [
    'name' => 'element',
    'type' => 'object' ,
    'id' => ['a'],
    'fields' => [
      ['field' => 'a', 'type' => 'integer']
    ]
  ]
]);

  $this->assertEquals(['name' => 'elements', 'type' => 'collection', 'elem' => [ 'name' => 'element', 'id' => ['a'], 'type' => 'object', 'fields' => [
  ['field' => 'a', 'type' => 'integer'],
  ['field' => 'id', 'type' => 'id', 'display' => true, 'fields' => ['a']]
]
]
], $c->resolve_type($c->collections['elements']));

}

function testResolveTypeCustomWithType() {
  $c = new C;

  $c->add([
    'name' => 'element',
    'type' => 'object' ,
    'fields' => [
      ['field' => 'a', 'type' => 'integer']
    ]
  ]);

  $c->add(
[
  'name' => 'elements',
  'type' => 'collection',
  'elem' => [
    'type' => 'custom' ,
    'type_name' => 'element' 
  ]
]);

  $this->assertEquals(['name' => 'elements', 'type' => 'collection', 'elem' => [ 'name' => 'element', 'type' => 'object', 'fields' => [
  ['field' => 'a', 'type' => 'integer'],
  ['field' => 'id', 'type' => 'id', 'display' => true, 'fields' => []]
]
]
], $c->resolve_type($c->collections['elements']));

}

function testResolveCustom() {
  $c = new C;

  $c->add([
    'name' => 'element',
    'type' => 'object' ,
    'label' => 'hola_old',
    'help' => 'help_old',
    'fields' => [
      ['field' => 'a', 'type' => 'integer']
    ]
  ]);

  $c->add(
[
  'name' => 'super_element',
  'type' => 'custom',
  'type_name' => 'element',
  'label' => 'hola',
  'fields' => [
    ['field' => 'b', 'type' => 'string']
  ]
]);

  $this->assertEquals(['name' => 'super_element', 'type' => 'object', 'label' => 'hola', 'help' => 'help_old', 'fields' => [
  ['field' => 'a', 'type' => 'integer'],
  ['field' => 'b', 'type' => 'string']
]
], $c->resolve_type($c->types['super_element']));


}

function testResolveCustom2() {
  $c = new C;

  $c->add([
    'name' => 'element',
    'type' => 'object' ,
    'label' => 'hola_old',
    'help' => 'help_old',
    'fields' => [
      ['field' => 'a', 'type' => 'integer']
    ]
  ]);

  $c->add(
[
  'name' => 'super_element',
  'type' => 'custom',
  'type_name' => 'element',
  'label' => 'hola',
  'fields' => [
    ['field' => 'b', 'type' => 'string']
  ]
]);

  $c->add(
[
  'name' => 'ultra_element',
  'type' => 'custom',
  'type_name' => 'super_element',
  'label' => 'hola_new',
  'fields' => [
    ['field' => 'c', 'type' => 'string']
  ]
]);

  $this->assertEquals(['name' => 'ultra_element', 'type' => 'object', 'label' => 'hola_new', 'help' => 'help_old', 'fields' => [
  ['field' => 'a', 'type' => 'integer'],
  ['field' => 'b', 'type' => 'string'],
  ['field' => 'c', 'type' => 'string']
]
], $c->resolve_type($c->types['ultra_element']));


}

function testResolveObject() {
  $c = new C;

  $c->add([
    'name' => 'element',
    'type' => 'object' ,
    'fields' => [
      ['field' => 'a', 'type' => 'custom', 'type_name' => 'e1'],
      ['field' => 'b', 'type' => 'custom', 'type_name' => 'e2'],
      ['field' => 'c', 'type' => 'custom', 'type_name' => 'e1'],
      ['field' => 'd', 'type' => 'custom', 'type_name' => 'e3']
    ]
  ]);

  $c->add([
    'name' => 'e1',
    'type' => 'string'
  ]);

  $c->add([
    'name' => 'e2',
    'type' => 'integer' 
  ]);

  $c->add([
    'name' => 'e3',
    'type' => 'custom',
    'type_name' => 'e2'
  ]);

  $this->assertEquals(['name' => 'element', 'type' => 'object', 'fields' => [
  ['field' => 'a', 'type' => 'string'],
  ['field' => 'b', 'type' => 'integer'],
  ['field' => 'c', 'type' => 'string'],
  ['field' => 'd', 'type' => 'integer']
]
], $c->resolve_type($c->types['element']));

}

function testResolveList() {
  $c = new C;

  $c->add([
    'name' => 'element',
    'type' => 'list' ,
    'elem' => [
      'type' => 'custom',
      'type_name' => 'e2'
    ]
  ]);

  $c->add([
    'name' => 'e1',
    'type' => 'integer'
  ]);

  $c->add([
    'name' => 'e2',
    'type' => 'custom',
    'type_name' => 'e1'
  ]);

  $this->assertEquals(['name' => 'element', 'type' => 'list', 'elem' => [ 'name' => 'e2', 'type' => 'integer']], $c->resolve_type($c->types['element']));

}

function testResolveTypeCustomWithType2() {
  $c = new C;

  $c->add(
[
  'name' => 'elements',
  'type' => 'collection',
  'elem' => [
    'name' => 'element',
    'type' => 'object' ,
    'fields' => [
      ['field' => 'a', 'type' => 'integer']
    ]

  ]
]);

  $this->assertEquals(['name' => 'elements', 'type' => 'collection', 'elem' => [ 'name' => 'element', 'type' => 'object', 'fields' => [
  ['field' => 'a', 'type' => 'integer'],
  ['field' => 'id', 'type' => 'id', 'display' => true, 'fields' => []]
]
]
], $c->resolve_type($c->collections['elements']));

}

}


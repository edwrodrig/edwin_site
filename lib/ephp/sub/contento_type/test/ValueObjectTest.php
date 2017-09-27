<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ValueObjTest extends TestCase {

function testGetField() {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id', 'fields' => ['a']],
    ['field' => 'a', 'type' => 'string']
  ]]);
  
  $this->assertEquals(['field' => 'id', 'type' => 'id', 'fields' => ['a']], $type->get_field('id')->data);
  $this->assertEquals(['field' => 'a', 'type' => 'string'], $type->get_field('a')->data);
  $this->assertNull($type->get_field('b'));
}

function getIdProvider() {
  return [
    ['aaa', ['a' => 'aaa']],
    ['aaaaa', ['a' => 'aAaAa----']],
    ['aa-aaa', ['a' => 'aA aAa----']],
    ['iii', ['id' => 'iii', 'a' => 'aaa']],
  ];
}

/**
 * @dataProvider getIdProvider
 */

function testGetId($expected, $value) {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id', 'fields' => ['a'], 'display' => true],
    ['field' => 'a', 'type' => 'string']
  ]]);

  $this->assertEquals($expected, $type($value)->get_field('id')());
}

function testGetId2() {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id', 'fields' => ['a', 'b']],
    ['field' => 'a', 'type' => 'string'],
    ['field' => 'b', 'type' => 'string']
  ]]);

  $this->assertEquals('aaa-bbb', $type(['a' => 'aaa', 'b' => 'bbb'])->get_field('id')());
}


function displayFieldsProvider() {
  return [
[['id' => 'id', 'a' => 'aaa'], ['id' => 'id', 'a' => 'aaa', 'b' => 'bbb'], 'display'],
[['id' => 'id', 'a' => 'aaa', 'b' => 'bbb'], ['id' => 'id', 'a' => 'aaa', 'b' => 'bbb'], 'full'],
[['id' => 'aaa-bbb', 'a' => 'aaa'], ['a' => 'aaa', 'b' => 'bbb'], 'display'],
[['id' => 'aaa-bbb', 'a' => 'aaa', 'b' => 'bbb'], ['a' => 'aaa', 'b' => 'bbb'], 'full']
  ];
}

/**
 * @dataProvider displayFieldsProvider
 */
function testDisplayFields($expected, $value, $mode) {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id', 'fields' => ['a', 'b'], 'display' => true],
    ['field' => 'a', 'type' => 'string', 'display' => true],
    ['field' => 'b', 'type' => 'string']]
  ]);

  $this->assertEquals($expected, $type($value)($mode));
}

function testGetIdNullNotFields() {
  $type = \contento\Type::create(['name' => 'data', 'type' => 'object', 'fields' => [
    ['field' => 'id', 'type' => 'id', 'display' => true],
    ['field' => 'a', 'type' => 'string'],
    ['field' => 'b', 'type' => 'string']
  ]]);

  $this->assertEquals(['field' => 'id', 'type' => 'id', 'display' => true], $type->get_field('id')->data);
  $this->assertEquals(0, strpos($type(['a' => 'aaa', 'b' => 'bbb'])('full')['id'], 'id-generated'));
}

function testDataCollection() {
  $type = \contento\Type::create(['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'id', 'type' => 'id'], ['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
   ]
  ]);

  $this->assertEquals(['id' => 'iii', 'a' => 'aaa', 'b' => 'bbb'], $type(['id' => 'iii', 'a' => 'aaa', 'b' => 'bbb'])());


}

function testDataCollectionIdGenerated() {
  $type = \contento\Type::create(['name' => 'collec',
   'type' => 'collection',
   'elem' => [
     'type' => 'object',
     'fields' => [['field' => 'id', 'type' => 'id'], ['field' => 'a', 'type' => 'string'], ['field' => 'b', 'type' => 'string']]
   ]
  ]);

  $data = $type(['a' => 'aaa', 'b' => 'bbb'])();

  $this->assertEquals('aaa', $data['a']);
  $this->assertEquals('bbb', $data['b']);
  $this->assertEquals(0, strpos($data['id'], 'id-generated'));
}

function testUpdateRef() {
  $type = \contento\Type::create([
   'type' => 'object',
   'fields' => [
     ['field' => 'a', 'type' => 'string'],
     ['field' => 'r', 'type' => 'ref', 'collection' => 'collec']
   ]
 ]);

  $value = $type(['a' => 'aaa', 'r' => 'hola']);

  $this->assertEquals(['a' => 'aaa', 'r' => 'hola'], $value('full'));

  $this->assertFalse($value->update_ref('other', 'hola', 'chao'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'hola'], $value('full'));

  $this->assertFalse($value->update_ref('collec', 'other', 'chao'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'hola'], $value('full'));

  $this->assertTrue($value->update_ref('collec', 'hola', 'chao'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'chao'], $value('full'));
}

function testUpdateRef2() {
  $type = \contento\Type::create([
   'type' => 'object',
   'fields' => [
     ['field' => 'a', 'type' => 'string'],
     ['field' => 'r', 'type' => 'ref', 'collection' => 'collec'],
     ['field' => 'rr', 'type' => 'ref', 'collection' => 'other'],
   ]
 ]);

  $value = $type(['a' => 'aaa', 'r' => 'hola', 'rr' => 'other']);

  $this->assertEquals(['a' => 'aaa', 'r' => 'hola', 'rr' => 'other'], $value('full'));

  $this->assertFalse($value->update_ref('other', 'hola', 'chao'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'hola', 'rr' => 'other'], $value('full'));

  $this->assertFalse($value->update_ref('collec', 'other', 'chao'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'hola', 'rr' => 'other'], $value('full'));

  $this->assertTrue($value->update_ref('collec', 'hola', 'chao'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'chao', 'rr' => 'other'], $value('full'));

  $this->assertTrue($value->update_ref('other', 'other', 'chao2'));
  $this->assertEquals(['a' => 'aaa', 'r' => 'chao', 'rr' => 'chao2'], $value('full'));
}

function testUpdateRef3() {
  $object = [
    'field' => 'o',
    'type' => 'object',
    'fields' => [
      ['field' => 'r', 'type' => 'ref', 'collection' => 'collec']
    ]
  ];

  $object['fields'][] = $object;
  $object['fields'][] = ['field' => 'l', 'type' => 'list', 'elem' => $object];

  $type = \contento\Type::create([
    'type' => 'object',
    'fields' => [
       $object,
       ['field' => 'l', 'type' => 'list', 'elem' => $object],
       ['field' => 'r', 'type' => 'ref', 'collection' => 'collec']
     ]
  ]);

  $struct = [
'o' => [
  'o' => ['r' => 'hola'],
  'r' => 'hola',
  'l' => [['o' => ['r' => 'hola'], 'r' => 'hola'], ['o' => ['r' => 'hola'], 'r' => 'hola']],
],
'l' => [
  [
    'o' => ['r' => 'hola'],
    'r' => 'hola',
    'l' => [['o' => ['r' => 'hola'], 'r' => 'hola'], ['o' => ['r' => 'hola'], 'r' => 'hola']],
  ],
  [
    'o' => ['r' => 'hola'],
    'r' => 'hola',
    'l' => [['o' => ['r' => 'hola'], 'r' => 'hola'], ['o' => ['r' => 'hola'], 'r' => 'hola']],
  ]
],
'r' => 'hola'
];

  $value = $type($struct);

  $this->assertFalse($value->update_ref('other', 'hola', 'chao'));
  $this->assertEquals($struct, $value('full'));
  $this->assertFalse($value->update_ref('collec', 'chao', 'hola'));
  $this->assertEquals($struct, $value('full'));

  $struct = [
'o' => [
  'o' => ['r' => 'chao'],
  'r' => 'chao',
  'l' => [['o' => ['r' => 'chao'], 'r' => 'chao'], ['o' => ['r' => 'chao'], 'r' => 'chao']],
],
'l' => [
  [
    'o' => ['r' => 'chao'],
    'r' => 'chao',
    'l' => [['o' => ['r' => 'chao'], 'r' => 'chao'], ['o' => ['r' => 'chao'], 'r' => 'chao']],
  ],
  [
    'o' => ['r' => 'chao'],
    'r' => 'chao',
    'l' => [['o' => ['r' => 'chao'], 'r' => 'chao'], ['o' => ['r' => 'chao'], 'r' => 'chao']],
  ]
],
'r' => 'chao'
];
  $this->assertTrue($value->update_ref('collec', 'hola', 'chao'));
  $this->assertEquals($struct, $value('full'));
  
}


function testUpdateRef4() {
  $type = \contento\Type::create(json_decode(file_get_contents(__DIR__ .'/files/icm_person.json'), true));

  $data = json_decode(file_get_contents(__DIR__ . '/files/icm_person_data.json'), true);

  $value = $type($data);
  $this->assertFalse($value->update_ref('icm_research_lines', 'h', 'a'));

}


}

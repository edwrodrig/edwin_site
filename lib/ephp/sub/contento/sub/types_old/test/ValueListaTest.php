<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../inc.php');

class ValueListaTest extends TestCase {

function testGetField() {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'list', 'elem' => [ 'type' => 'string']]);
  
  $this->assertEquals(['type' => 'string'], $type->elem()->data);
}


function testGetData() {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'list', 'elem' => [ 'type' => 'string']]);

  $data = $type(['hola', 'como', 'te', 'va']);

  $this->assertEquals(['hola', 'como', 'te', 'va'], $data());
}

function testUpdateRef() {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'list', 'elem' => [ 'type' => 'ref', 'collection' => 'collec']]);
  
  $value = $type(['hola', 'como', 'te', 'va']);

  $this->assertFalse($value->update_ref('other', 'hola', 'chao'));
  $this->assertEquals(['hola', 'como', 'te', 'va'], $value());

  $this->assertFalse($value->update_ref('collec', 'other', 'chao'));
  $this->assertEquals(['hola', 'como', 'te', 'va'], $value());

  $this->assertTrue($value->update_ref('collec', 'hola', 'chao'));
  $this->assertEquals(['chao', 'como', 'te', 'va'], $value());

  $this->assertTrue($value->update_ref('collec', 'va', 'chao'));
  $this->assertEquals(['chao', 'como', 'te', 'chao'], $value());

  $this->assertTrue($value->update_ref('collec', 'chao', 'hola'));
  $this->assertEquals(['hola', 'como', 'te', 'hola'], $value());
}

function testUpdateRef2() {
  $type = \contento\Type::create(['name' => 'id', 'type' => 'list', 'elem' => [ 'type' => 'object', 'fields' => [['field' => 'll', 'type' => 'list', 'elem' => ['type' => 'ref', 'collection' => 'collec']]]]]);

  $value = $type([['ll' => ['hola', 'como', 'te', 'va']],
                  ['ll' => []],
                  ['ll' => ['va', 'te', 'como', 'hola']],
                  ['ll' => ['hola', 'hola']]
                 ]);

  $this->assertFalse($value->update_ref('other', 'hola', 'chao'));
  $this->assertEquals([['ll' => ['hola', 'como', 'te', 'va']],
                  ['ll' => []],
                  ['ll' => ['va', 'te', 'como', 'hola']],
                  ['ll' => ['hola', 'hola']]
                 ], $value());

  $this->assertFalse($value->update_ref('collec', 'other', 'chao'));
  $this->assertEquals([['ll' => ['hola', 'como', 'te', 'va']],
                  ['ll' => []],
                  ['ll' => ['va', 'te', 'como', 'hola']],
                  ['ll' => ['hola', 'hola']]
                 ], $value());

  $this->assertTrue($value->update_ref('collec', 'hola', 'chao'));
  $this->assertEquals([['ll' => ['chao', 'como', 'te', 'va']],
                  ['ll' => []],
                  ['ll' => ['va', 'te', 'como', 'chao']],
                  ['ll' => ['chao', 'chao']]
                 ], $value());

  $this->assertTrue($value->update_ref('collec', 'va', 'chao'));
  $this->assertEquals([['ll' => ['chao', 'como', 'te', 'chao']],
                  ['ll' => []],
                  ['ll' => ['chao', 'te', 'como', 'chao']],
                  ['ll' => ['chao', 'chao']]
                 ], $value());

  $this->assertTrue($value->update_ref('collec', 'chao', 'hola'));
  $this->assertEquals([['ll' => ['hola', 'como', 'te', 'hola']],
                  ['ll' => []],
                  ['ll' => ['hola', 'te', 'como', 'hola']],
                  ['ll' => ['hola', 'hola']]
                 ], $value());
}


}

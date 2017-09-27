<?php
require_once(__DIR__ . '/../include.php');

use PHPUnit\Framework\TestCase;

class Entity extends \ephp\data\Entity {

function some() {
  return ($this['name'] ?? '') . '_some' ;
}

}

class EntityTest extends TestCase {

function testAtrib() {
  $e = new Entity(['name' => 'edwin', 'surname' => 'rodriguez']);

  $this->assertEquals('rodriguez', $e['surname']);
  $this->assertEquals('edwin_some', $e['some']);
  $this->assertEquals('edwin_some', $e->some());
}

}


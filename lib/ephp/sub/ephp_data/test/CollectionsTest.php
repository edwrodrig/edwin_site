<?php
require_once(__DIR__ . '/../include.php');

use \ephp\data\Collections;
use PHPUnit\Framework\TestCase;

class CollectionTests extends TestCase {

function testExample() {
  $collections = new Collections();
  $collections['personas'] = ['edw' => ['name' => 'edwin', 'surname' => 'rodriguez']];

  $e = $collections['personas']['edw'];

  $this->assertEquals('edwin', $e['name']);
  $this->assertEquals('rodriguez', $e['surname']);
}

}


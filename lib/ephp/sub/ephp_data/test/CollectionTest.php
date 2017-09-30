<?php
require_once(__DIR__ . '/../include.php');

use \ephp\data\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase {

function testExample() {
  $collection = new Collection('hola');
  $collection->set(['edw' => ['name' => 'edwin', 'surname' => 'rodriguez']]);

  $e = $collection['edw'];

  $this->assertEquals('edwin', $e['name']);
  $this->assertEquals('rodriguez', $e['surname']);
}

function testUndefined() {
  $collection = new Collection('hola');

  $e = $collection['edw'] ?? 'hola';

  $this->assertEquals('hola', $e);
}

function testTransversable() {
  $collection = new Collection('hola');
  $collection->set(['edw' => ['name' => 'edwin', 'surname' => 'rodriguez'],
                    'edg' => ['name' => 'edgar', 'surname' => 'rodriguez']]);

  $count = 0;
  
  foreach ( $collection as $index => $e ) {
    if ( $index == 'edw' ) {
      $this->assertEquals('edwin', $e['name']);
      $count++;
    }
    if ( $index == 'edg' ) {
      $this->assertEquals('edgar', $e['name']);
      $count++;
    }
  }

  $this->assertEquals(2, $count);

}


}


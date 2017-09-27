<?php

require_once(__DIR__ . '/../include.php');

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase {


static function setUpBeforeClass() {
  \ephp\data\Data::set('imo', ['person' => '\ephp\data\Entity', 'duration' => '\ephp\data\EntityDuration']);
}


function testExample() {
  data('imo')['person'] = [
    'edw' => ['name' => 'edwin', 'surname' => 'rodriguez'],
    'edg' => ['name' => 'edgar', 'surname' => 'rodriguez']
  ];

  data('imo')['duration'] = [
    ['start_date' => '1900-01-01', 'end_date' => '2000-01-01'],
    ['start_date' => '1985-02-02', 'end_date' => '1990-12-25']
  ];


  $e = data('imo')['person']['edw'];

  $this->assertEquals('edwin', $e['name']);
  $this->assertEquals('rodriguez', $e['surname']);


  $e = data('imo')['duration'][0];
  
  $this->assertEquals('1900-01-01', $e['start_date']);
}

}


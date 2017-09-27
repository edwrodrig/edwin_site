<?php
require_once(__DIR__ . '/../include.php');

use PHPUnit\Framework\TestCase;
use ephp\data\EntityDuration;

class EntityDurationTest extends TestCase { 

function collection($data) {
  $collection = new \ephp\data\Collection('durations', '\ephp\data\EntityDuration');
  $collection->set($data);
  return $collection;
}

function create($data) {
  return new EntityDuration($data);
}

function testInterval() {
  $this->assertEquals(false, $this->create([])->is_expired());
  $this->assertEquals(false, $this->create([])->is_about_to_start());
  $this->assertEquals(true, $this->create(['start_date' => '0000-00-00', 'end_date' => '2000-99-99'])->is_expired());
  $this->assertEquals(true, $this->create(['start_date' => '3000-00-00', 'end_date' => '3200-99-99'])->is_about_to_start());
  $this->assertEquals(true, $this->create(['start_date' => '0000-00-00', 'end_date' => ''])->is_active());
  $this->assertEquals(true, $this->create(['start_date' => '', 'end_date' => '3000-99-99'])->is_active());
  $this->assertEquals(true, $this->create(['start_date' => '', 'end_date' => '----'])->is_active());
  $this->assertEquals(true, $this->create([])->is_active());
}

function intervalExpiredDataProvider() {
  return [
    [false, [], null],
    [true , [ 'start_date' => '0000-00-00', 'end_date' => '2000-99-99'], null],
    [true, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '3000-04-01'],
    [false, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '3000-01-11'],
    [false, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '2999-04-01']
  ];
}

/**
 * @dataProvider intervalExpiredDataProvider
 */
function testIntervalExpired($result, $interval, $today) {
  $this->assertEquals($result, $this->create($interval)->is_expired($today));
}

function intervalAboutToStartDataProvider() {
  return [
    [false, [], null],
    [true, ['start_date' => '3000-00-00', 'end_date' => '3200-99-99'], null],
    [false, ['start_date' => '3000-00-00', 'end_date' => '3200-99-99'], '3100-01-01'],
    [false, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '3000-04-01'],
    [false, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '3000-01-11'],
    [true, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '2999-04-01']
  ];
}

/**
 * @dataProvider intervalAboutToStartDataProvider
 */
function testIntervalAboutToStart($result, $interval, $today) {
  $this->assertEquals($result, $this->create($interval)->is_about_to_start($today));
}


function intervalActiveDataProvider() {
  return [
    [true, [], null],
    [false, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '3000-04-01'],
    [true, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '3000-01-11'],
    [false, [ 'start_date' => '3000-01-01', 'end_date' => '3000-02-01'], '2999-04-01']
  ];
}

/**
 * @dataProvider intervalActiveDataProvider
 */
function testIntervalActive($result, $interval, $today) {
  $this->assertEquals($result, $this->create($interval)->is_active($today));
}


function testIntervalLast() {
  $c = $this->collection([
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00'],
    ['start_date' => '2000-00-00', 'end_date' => '2010-00-00']
  ]);
  $e = EntityDuration::last($c, function($e) { return $e; });

  $this->assertEquals(['start_date' => '2000-00-00', 'end_date' => '2010-00-00'], $e->data);

  $c = $this->collection([
    ['start_date' => '2000-00-00', 'end_date' => '2010-00-00'],
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00']
  ]);
  $e = EntityDuration::last($c, function($e) { return $e; });

  $this->assertEquals(['start_date' => '2000-00-00', 'end_date' => '2010-00-00'], $e->data);

  $c = $this->collection([
    ['start_date' => '2000-00-00', 'end_date' => '2010-00-00'],
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00'],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00']
  ]);
  $e = EntityDuration::last($c, function($e) { return $e; });

  $this->assertEquals(['start_date' => '2000-00-00', 'end_date' => '2010-00-00'], $e->data);

  $c = $this->collection([
    ['start_date' => '2000-00-00', 'end_date' => '2010-00-00', 'ok' => true],
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00', 'ok' => true],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00', 'ok' => true]
  ]);
  $e = EntityDuration::last($c, function($e) { if ( $e['ok'] ) return $e; else return null; });

  $this->assertEquals(['start_date' => '2000-00-00', 'end_date' => '2010-00-00', 'ok' => true], $e->data);

  $c = $this->collection([
    ['start_date' => '2000-00-00', 'end_date' => '2010-00-00', 'ok' => false],
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00', 'ok' => true],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00', 'ok' => true]
  ]);

  $e = EntityDuration::last($c, function($e) { if ( $e['ok'] ) return $e; else return null; });

  $this->assertEquals(['start_date' => '0000-00-00', 'end_date' => '1000-00-00', 'ok' => true], $e->data);
}

function testIntervalOngoing() {
  $c = $this->collection([
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00'],
    ['start_date' => '2000-00-00', 'end_date' => '3000-00-00'],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00']
  ]);
  $e = EntityDuration::ongoing($c, function($e) { return $e; });

  $this->assertEquals(['start_date' => '2000-00-00', 'end_date' => '3000-00-00'], $e->data);

  $c = $this->collection([
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00'],
    ['start_date' => '2001-00-00', 'end_date' => '3001-00-00'],
    ['start_date' => '2000-00-00', 'end_date' => '3000-00-00'],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00']
  ]);
  $e = EntityDuration::ongoing($c, function($e) { return $e; });

  $this->assertEquals(['start_date' => '2001-00-00', 'end_date' => '3001-00-00'], $e->data);

  $c = $this->collection([
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00', 'ok' => false],
    ['start_date' => '2001-00-00', 'end_date' => '3001-00-00', 'ok' => false],
    ['start_date' => '2000-00-00', 'end_date' => '3000-00-00', 'ok' => true ],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00', 'ok' => true ]
  ]);
  $e = EntityDuration::ongoing($c, function($e) { if ( $e['ok'] ) return $e; else return null; });

  $this->assertEquals(['start_date' => '2000-00-00', 'end_date' => '3000-00-00', 'ok' => true], $e->data);

  $c = $this->collection([
    ['start_date' => '0000-00-00', 'end_date' => '1000-00-00'],
    ['start_date' => '3000-00-00', 'end_date' => '4000-00-00']
  ]);

  try {
    $e = EntityDuration::ongoing($c,  function($e) { return $e; });
    $this->assertFalse(true, 'should throw');
  } catch ( \Exception $e ) {
    $this->assertTrue(true, 'throw');

  }

}


}


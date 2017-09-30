<?php
use PHPUnit\Framework\TestCase;
use ephp\web\Metric;

require_once(__DIR__ . '/../include.php');

class MetricTest extends TestCase {

function testMetricDefault() {
  $this->assertEquals('1em', new Metric('1em'));
  $this->assertEquals('30px', new Metric('30px'));
  $this->assertEquals('100%', new Metric('100%'));
}

function testMetricOperation() {
  $m = new Metric('1em');
  $this->assertEquals('1em', $m);
  $m('+', '2em');
  $this->assertEquals('3em', $m);
  $m('+', '2px');
  $this->assertEquals('3em', $m);
  $m('-', '1em');
  $this->assertEquals('2em', $m);
/*
  $m('*', new Metric('2.5em'));
  $this->assertEquals('5em', $m);
  $m('/', new Metric('2em'));
  $this->assertEquals('2.5em', $m);
*/

}


}


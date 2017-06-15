<?php

namespace ephp\web;

class Metric {

public $value = 1;
public $unit = 'em';

function __construct($arg) {
  if ( $arg instanceof Metric ) {
    $value = $arg->value;
    $unit = $arg->unit;
  } else if ( is_string($arg) ) {
    $matches;
    if ( preg_match('/([\d\.]+)([\w%]+)/', $arg, $matches) ) {
      $this->value = floatval($matches[1]);
      $this->unit = $matches[2];
    }
  }
}

function __invoke($operator, $metric) {
  if ( is_string($metric) ) $metric = new Metric($metric);
  if ( $this->unit !== $metric->unit ) return;
  if ( $operator === '+' ) $this->value += $metric->value;
  if ( $operator === '-' ) $this->value -= $metric->value;
  if ( $operator === '*' ) $this->value *= $metric->value;
  if ( $operator === '/' ) $this->value /= $metric->value;
}

function __toString() {
  return $this->value . $this->unit;
}



}



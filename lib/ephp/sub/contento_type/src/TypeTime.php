<?php
namespace contento;

class TypeTime extends Type  {

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new ValueTime($data, $this);
}

function default_value() {
  $default = parent::default_value();
  return $default;
}

}

class ValueTime extends Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function set($value) {
  parent::set($value);
  $value = trim($value ?? '');
  if ( empty($value) ) $value = null;
  parent::set($value);
}

function validate($value) {
  parent::validate($value);

  if ( is_null($value) ) return;
  if ( $value != date('H:i',strtotime($value)) )
    $this->fire('TIME_INVALID');
}

}

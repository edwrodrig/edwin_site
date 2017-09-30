<?php
namespace contento;

class TypeDateTime extends Type  {

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new ValueDateTime($data, $this);
}

function default_value() {
  $default = parent::default_value();
  if ( !empty($default) && $default == 'now') {
    $default = date('Y-m-d H:i');
  }
  return $default;
}

}

class ValueDateTime extends Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function set($value) {
  parent::set($value);
  $value = trim($value ?? '');
  if ( empty($value) ) $value = null;
  else if ( $value == 'now' ) $value = date('Y-m-d H:i');
  parent::set($value);
}

function validate($value) {
  parent::validate($value);

  if ( is_null($value) ) return;
  if ( $value != date('Y-m-d H:i',strtotime($value)) )
    $this->fire('DATETIME_INVALID');
}

}

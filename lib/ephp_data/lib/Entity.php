<?php
namespace ephp\data;

class Entity implements \ArrayAccess {

public $data;

function __construct($data) {
  $this->data = $data;
}

function __call($name, $args) {
  return $this->data[$name] ?? $args[0] ?? null;
}

function traverse($name, $entity = '') {
  foreach ( $this->data[$name] ?? [] as $key => $value ) {
    yield $key => \Data::new_class($entity, $value);
  }
}

function offsetSet($offset, $value) {
  if (is_null($offset)) {
    $this->data[] = $value;
  } else {
    $this->data[$offset] = $value;
  }
}

function offsetExists($offset) {
  return isset($this->data[$offset]);
}

function offsetUnset($offset) {
  unset($this->data[$offset]);
}

function offsetGet($offset) {
  return $this->{$offset}();
}

}

trait EntityDateInterval {

function is_active($today = null) {
  $today = $today ?? date('Y-m-d');
  if ( $this->is_expired($today) ) return false;
  if ( $this->is_about_to_start($today) ) return false;
  return true;
}

function start_date($default = '0000-00-00') {
  return $this->data['duration']['start_date'] ?? $default;
}

function end_date($default = '9999-99-99') {
  return $this->data['duration']['end_date'] ?? $default;
}

function is_expired($today = null) {
  $today = $today ?? date('Y-m-d');
  return $this->start_date('0000-00-00') < $today && $this->end_date('9999-99-99') < $today;
}

function is_about_to_start($today = null) {
  $today = $today ?? date('Y-m-d');
  return $this->start_date('0000-00-00') > $today && $this->end_date('9999-99-99') > $today;
}

public static function last($list, $filter = null) {
  $last = null;
  foreach ( $list ?? [] as $e ) {
    if ( isset($filter) ) { if ( !$filter($e) ) continue; }
    if ( !$e->is_expired() ) continue;
    if ( is_null($last) || $last->end_date() < $e->end_date() ) $last = $e;
  }
  return $last;
}

public static function ongoing($list, $filter = null) {
  foreach ( $list ?? [] as $e ) {
    if ( isset($filter) ) { if ( !$filter($e) ) continue; }
    if ( $e->is_active() ) return $e;
  }
  return null;

}

}

<?php
namespace ephp\data;

class Entity implements \ArrayAccess {

public $data;

function __construct($data) {
  $this->data = $data;
}

function offsetSet($offset, $value) {
  //read only
}

function offsetExists($offset) {
  try {
    $this->offsetGet($offset);
    return true;
  } catch ( \Exception $e ) {
    return false;
  }
}

function offsetUnset($offset) {
  //read only
}

function offsetGet($offset) {
  if ( method_exists($this, $offset) ) return $this->{$offset}();
  if ( isset($this->data[$offset]) ) return $this->data[$offset];
  $this->throw_error($offset);
}

static function create($data) {
  $class = get_called_class();
  return new $class($data);
}

protected function key_not_exists_message($offset, $message = 'Key not exists') {
  return sprintf( ' : key[%s] data[%s]', $offset, json_encode($this->data, JSON_PRETTY_PRINT));
}

function throw_error($offset, $message = 'Key not exists') {
  throw new \Exception($this->key_not_exists_message($offset, $message));
}

function fallback(...$offsets) {
  $first_element = array_shift($offsets);
  if ( isset($this[$first_element] ) ) return $this[$first_element];
  else {
    error_log($this->key_not_exists_message($first_element));
    foreach ( $offsets as $offset ) {
      if ( isset($this[$offset]) ) return $this[$offset];
    }
    $this->throw_error($first_element);
  }
}


}


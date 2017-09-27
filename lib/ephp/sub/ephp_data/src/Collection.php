<?php
namespace ephp\data;

class Collection implements \ArrayAccess , \IteratorAggregate {

public $entity = '\ephp\data\Entity';
public $data = [];
public $id = 'collection';

function __construct($id, $entity = '\ephp\data\Entity') {
  $this->id = $id;
  $this->entity = $entity;
}

function set($elements) {
  foreach ( $elements as $index => $element ) {
    if ( isset($element['id']) )
      $this->data[$element['id']] = $element;
    else
      $this->data[$index] = $element;
  }
} 

function sort($function = null) {
  if ( is_null($function) ) {
    uasort($this->data, function($a, $b) {
      return ($this->entity)::compare(
        $this->create_element($a),
        $this->create_element($b)
      );
    });

  } else {
    uasort($this->data, function($a, $b) use($function) {
      return $function(
        $this->create_element($a),
        $this->create_element($b)
      );
    });
  }
}

function rsort() {
  uasort($this->data, function($b, $a) {
    return ($this->entity)::compare(
      $this->create_element($a),
      $this->create_element($b)
    );
  });
}

function offsetExists($offset) {
  return isset($this->data[$offset]);
}

function dummy() {
  return $this->create_element([]);
}

function create_element($data) {
  return new $this->entity($data);
}

function offsetGet($offset) {
  if ( isset($this->data[$offset]) )
    return $this->create_element($this->data[$offset]);
  else
    throw new \Exception(sprintf('Data [%s] with id [%s] does not exists', $this->id, $offset));
}

function offsetSet($offset, $value) {
  if ( is_null($offset) )  
    $this->data[] = $value;
  else 
    $this->data[$offset] = $value;
}

function offsetUnset($offset) { unset($this->data[$offset]); }

function getIterator() {
  return entity_iterator($this->data, $this->entity);
}

}



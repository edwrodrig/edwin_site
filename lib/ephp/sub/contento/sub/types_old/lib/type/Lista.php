<?php
namespace contento\type {

class Lista extends \contento\Type  {

function __construct($data) {
  parent::__construct($data);
}

function elem() {
  return \contento\Type::create($this->data['elem']);
}

function __invoke($data) {
  return new \contento\value\Lista($data, $this);
}

}

}

namespace contento\value {

class Lista extends \contento\Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function elems() {
  $type = $this->type->elem();
  foreach ( $this->data ?? []  as $index => $data ) {
    yield $index => $this->type->elem()($data);
  }
}

function update_ref($collection, $old, $new) {
  $modified = false;
  foreach ( $this->elems() as $index => $elem ) {
    if ( $elem->update_ref($collection, $old, $new) ) {  
      $this->data[$index] = $elem();
      $modified = true;
    }
  }
  return $modified;
}

function __invoke() {
  $r = [];
  foreach ( $this->elems() as $field ) {
    $r[] = $field();
  }
  return $r;
}

}

}

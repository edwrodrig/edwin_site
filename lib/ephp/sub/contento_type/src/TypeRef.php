<?php
namespace contento;

class TypeRef extends Type {

function __construct($data) {
  parent::__construct($data);
}

function is_ref() { return true; }

function collection() {
  return $this->data['collection'];
}

function __invoke($data) {
  return new ValueRef($data, $this);
}

}

class ValueRef extends Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function update_ref($collection, $old, $new) {
  if ( $old === $new ) return false;
  if ( $this->type->collection() != $collection ) return false;
  if ( $this->data != $old ) return false;
  $this->data = $new;
  return true;
}

}


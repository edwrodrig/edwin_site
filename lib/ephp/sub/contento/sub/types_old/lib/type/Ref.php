<?php
namespace contento\type {

class Ref extends \contento\Type {

function __construct($data) {
  parent::__construct($data);
}

function collection() {
  return $this->data['collection'];
}

function __invoke($data) {
  return new \contento\value\Ref($data, $this);
}

}

}

namespace contento\value {

class Ref extends \contento\Value {

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

}


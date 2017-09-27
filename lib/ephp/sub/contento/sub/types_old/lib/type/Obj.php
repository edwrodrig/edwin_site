<?php
namespace contento\type {

class Obj extends \contento\Type  {

function __construct($data) {
  parent::__construct($data);
}

function fields() {
  foreach ( $this->data['fields'] ?? [] as $field ) {
    yield $field['field'] => \contento\Type::create($field);
  }
}

function get_field($name) {
  foreach( $this->fields() as $field ) {
    if ( $field->field() === $name )
      return $field;
  }
  return null;
}

function __invoke($data) {
  return new \contento\value\Obj($data, $this);
}

}

}

namespace contento\value {

class Obj extends \contento\Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function fields() {
  foreach ( $this->type->fields() as $field ) {
    yield $this->get_field($field->field());
  }
}

function set($data) {
  if ( $data instanceOf \contento\Value ) {
    $this->data[$data->type->field()] = $data();
  } else {
    $this->data = $data;
  }
}

function update_ref($collection, $old, $new) {
  $modified = false;
  foreach ( $this->fields() as $field ) {
    if ( $field->update_ref($collection, $old, $new) ) {  
      $this->set($field);
      $modified = true;
    }
  }
  return $modified;
}

function get_field($name) {
  $field = $this->type->get_field($name);
  if ( $field ) {
    $value = $field($this->data[$name] ?? null);
    if ( $value instanceOf \contento\value\Id ) {
      $value->parentObject = $this;
    }
    return $value;
  } else return null;
}

function __invoke($type = 'full') {
  $r = [];
  foreach ( $this->fields() as $field ) {
    if ( $type == 'display' && !$field->type->display() ) continue;
    $value = $field();
    if ( isset($value) )
      $r[$field->type->field()] = $value;
  }
  return $r;
}

function __toString() {
  return json_encode($this->__invoke('full'), JSON_PRETTY_PRINT);
}

}


}

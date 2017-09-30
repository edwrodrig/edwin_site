<?php
namespace contento;

class TypeObject extends Type  {

function __construct($data) {
  parent::__construct($data);
}

function fields() {
  foreach ( $this->data['fields'] ?? [] as $field ) {
    yield $field['field'] => Type::create($field);
  }
}

function displayable() { return false; }

function get_field($name) {
  foreach( $this->fields() as $field ) {
    if ( $field->field() === $name )
      return $field;
  }
  return null;
}

function routes() {
  $routes = parent::routes();

  foreach ( $this->fields() as $name => $field ) {
    $field_routes = $field->routes();

    foreach ( $field_routes as $route ) {
      $routes[] = empty($route) ? $name : "$name.$route";
    }
  }
  return $routes;
}

function __invoke($data) {
  return new ValueObject($data, $this);
}

}

class ValueObject extends Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function fields() {
  foreach ( $this->type->fields() as $field ) {
    yield $this->get_field($field->field());
  }
}

function set($data) {
  if ( $data instanceOf Value ) {
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
    if ( $value instanceOf ValueId ) {
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

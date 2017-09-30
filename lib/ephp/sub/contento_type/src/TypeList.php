<?php
namespace contento;

class TypeList extends Type  {

function __construct($data) {
  parent::__construct($data);
}

function elem() {
  return Type::create($this->data['elem']);
}

function displayable() {
  return false;
}

function __invoke($data) {
  return new ValueList($data, $this);
}

function routes() {
  $routes = parent::routes();
  
  $elem_routes = $this->elem()->routes();
  foreach ( $elem_routes as $route ) {
    $routes[] = empty($route) ? "elem" : "elem.$route";
  }

  return $routes;
}

}

class ValueList extends Value {

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


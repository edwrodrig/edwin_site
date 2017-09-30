<?php
namespace contento;

class Value {

public $data;
public $type;

function __construct($data, $type) {
  $this->type = $type;
  $this->set($data);
}

function set($data) { 
  if ( is_null($data) ) {
    $data = $this->type->default_value();
  }
  $this->data = $data;
}

function update_ref($collection, $old, $new) { return false; }

function validate($value) {
  if ( $this->type->required() && is_null($value) )
    $this->fire('VALUE_REQUIRED');
}

function fire($except) {
  Error::fire($except, $this->type->json());
}

function __invoke() {
  $this->validate($this->data);
  return $this->data;
}

function __toString() { return strval($this->data); }

}



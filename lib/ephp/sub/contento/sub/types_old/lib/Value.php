<?php
namespace contento;

class Value {

public $data;
public $type;

function __construct($data, $type) {
  $this->data = $data;
  $this->type = $type;
}

function set($data) { $this->data = $data; }

function update_ref($collection, $old, $new) { return false; }

function __invoke() { return $this->data; }

function __toString() { return strval($this->data); }

}



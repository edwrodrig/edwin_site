<?php
namespace contento;

class TypeImageRef extends Type  {

function __construct($data) {
  parent::__construct($data);
}

function collection() { return 'image'; }

function is_ref() { return true; }

function displayable() { return false; }

function __invoke($data) {
  return new ValueImageRef($data, $this);
}

}

class ValueImageRef extends Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

}

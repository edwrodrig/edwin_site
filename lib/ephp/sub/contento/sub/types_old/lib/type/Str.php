<?php
namespace contento\type {

class Str extends \contento\Type {

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new \contento\value\Str($data, $this);
}

}

}

namespace contento\value {

class Str extends \contento\Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function __toString() {
  if ( is_array($this->data) ) {
    foreach ( $this->data as $value ) return $value;
    return '';
  } else {
    return $this->data;
  }
}

}

}


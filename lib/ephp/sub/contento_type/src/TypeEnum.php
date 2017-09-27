<?php
namespace contento;

class TypeEnum extends Type {

public $data;

function __construct($data) {
  parent::__construct($data);
}

function options() {
  foreach ( $this->data['options'] as $option ) {
    yield $option;
  }
}

}


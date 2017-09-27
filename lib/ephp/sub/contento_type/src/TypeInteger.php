<?php
namespace contento;

class TypeInteger extends Type {

public $data;

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new ValueString($data, $this);
}



}

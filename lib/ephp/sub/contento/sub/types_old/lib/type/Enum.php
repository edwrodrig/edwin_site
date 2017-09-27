<?php
namespace contento\type;

class Enum {

public $data;

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new contento\value\Enum($data, $this);
}



}

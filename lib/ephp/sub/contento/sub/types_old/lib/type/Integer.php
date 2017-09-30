<?php
namespace contento\type;

class Str {

public $data;

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new contento\value\Str($data, $this);
}



}

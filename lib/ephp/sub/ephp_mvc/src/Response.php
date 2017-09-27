<?php
namespace ephp\mvc;

class Response {

public $request;

function __invoke($args = null) {
  return ($this->request)($args);
}

}



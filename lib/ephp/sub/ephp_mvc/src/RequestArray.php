<?php
namespace ephp\mvc;

class RequestArray extends Request {

function __construct() {
  parent::__construct();
}

function __invoke($args) {
  if ( is_array($args) )
    return $this->invoke_action($args[0] ?? null, array_slice($args, 1));
  else 
    return $this->invoke_action(null, []);
}

}



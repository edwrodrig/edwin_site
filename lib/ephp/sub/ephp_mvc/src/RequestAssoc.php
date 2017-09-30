<?php
namespace ephp\mvc;

class RequestAssoc extends Request {

function __invoke($args) {
  return $this->invoke_action($args['action'] ?? null, $args);
}

}



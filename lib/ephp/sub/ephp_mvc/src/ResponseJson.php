<?php
namespace ephp\mvc;

class ResponseJson extends ResponseAssoc {

function __invoke($args = []) {
  return json_encode(parent::__invoke($args));
}

}



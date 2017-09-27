<?php
namespace ephp\mvc;

class RequestJson extends RequestAssoc {

function __invoke($args) {
  return parent::__invoke(json_decode($args, true));
}

}



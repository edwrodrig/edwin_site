<?php
namespace ephp\mvc;

class RequestHttp extends RequestAssoc {

public $default_input = "php://input";

function __invoke($args = null) {
  if ( self::is_json() ) { 
    return parent::__invoke(json_decode(file_get_contents($this->default_input), true));
  }
  else
    return parent::__invoke($_GET + $_POST + $_FILES);
}

static function is_json() {
  return empty($_GET) && empty($_POST) && empty($_FILES);
}

}



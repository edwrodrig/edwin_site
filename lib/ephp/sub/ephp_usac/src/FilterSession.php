<?php
namespace ephp\usac;

class FilterSession {

public $usac_model;

function __invoke(array $args) {
  if ( isset($args['session']) ) {
    if ( $session = $this->usac_model->user_by_session($args['session']) ) {
      $args['session'] = $session;
      return $args; 
    } else Error::fire('SESSION_INVALID');
  } else return $args;
}

}


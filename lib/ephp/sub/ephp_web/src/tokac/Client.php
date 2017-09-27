<?php

namespace ephp\web\tokac;

class Client extends \ephp\web\Client{

public static $default_server;

function __construct($server = '') {
  $this->name = 'EPHP_TOKAC_CLIENT';
  $this->class_path = __DIR__ . '/client';

  if ( empty($server) ) $this->server = self::$default_server;
  else $this->server = $server;
}

function __invoke() {
  if ( dg() ) parent::js_script();
}

}


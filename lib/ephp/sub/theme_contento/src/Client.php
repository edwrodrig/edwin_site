<?php

namespace theme\contento;

class Client extends \ephp\web\Client {

public static $default_server = null;

function __construct($server = null) {
  if ( empty($server) ) $server = self::$default_server;
  $this->server = $server;
  $this->name = 'CONTENTO_CLIENT';
  $this->class_path = __DIR__ . '/client';
}

function __invoke() {
  if ( dg() ) parent::js_script();
}

}


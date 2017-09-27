<?php

namespace ephp\mvc;

class MailSender {

public $credentials = [];
public $actions = [];

function __construct($credentials = []) {
  $this->credentials = $credentials;
}

function add_action(...$action) {
  array_push($this->actions,  ...$action);
}

function __call($name, $arguments) {
  $message = null;
  foreach ( $this->actions as $action ) {
    $class = new \ReflectionClass($action);
    if ( !$class->hasMethod($name) ) continue;
    $method = $class->getMethod($name);
    $message = $method->invokeArgs($action, $arguments);
  }
  
  if ( empty($message) ) return false;
  
  $smtp = new \ephp\mail\Smtp($this->credentials);
  $smtp->send($message);
  return $message;
}

function test($destination) {
  $smtp = new \ephp\mail\Smtp($this->credentials);
  $smtp->send([
    'from' => ['text' => 'EPHP Mail sender'],
    'to' => ['text' => 'Tester', 'mail' => $destination],
    'subject' => 'Test mail from ephp_mvc',
    'plain' => 'If you received this mail then ephp_mail is correctly configured'
  ]);
  return true;
}

}

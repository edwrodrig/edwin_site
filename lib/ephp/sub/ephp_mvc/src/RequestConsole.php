<?php
namespace ephp\mvc;

class RequestConsole extends RequestArray {

function __construct() {
  parent::__construct();
  $help_action = new ActionHelp;
  $help_action->request = $this;
  $this->add_action($help_action);
}

function __invoke($arg = null) {
  try {
    if ( !isset($arg) ) {
      $arg = array_slice($GLOBALS['argv'] ?? [], 1);
    }
    parent::__invoke($arg);
    exit(0);
  } catch ( \Exception $e ) {
    if ( $e->getMessage() === 'ACTION_NOT_SPECIFIED' && $this->print_help() ) exit(1);
    else if ( $e->getMessage() === 'ACTION_NOT_AVAILABLE' && $this->print_help() ) exit(1);
    else {
      printf("Error:\n%s\n", $e->getMessage());
      exit(1);
    }
  }
}

function print_help() {
  $this->invoke_action('help', []);
  return true;
}

}




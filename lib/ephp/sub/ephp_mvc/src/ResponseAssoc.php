<?php
namespace ephp\mvc;

class ResponseAssoc extends Response {

public $error_logging_enabled = false;

function __invoke($args = []) {
  try {
    $ret = parent::__invoke($args);
    return ['status' => 0, 'data' => $ret];

  } catch ( \Exception $e ) {
    $ret = [
      'status' => -1,
      'code' => $e->getCode(),
      'message' => $e->getMessage()
    ];
  
    if ( isset($e->desc) )
      $ret['description'] = $e->desc;
    
    if ( $this->error_logging_enabled ) {
      ob_start();
      var_dump($ret);
      error_log(ob_get_clean());
    }
    return $ret;
  }
}

}



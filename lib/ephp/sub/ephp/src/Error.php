<?php
namespace ephp;

class Error {

static function fire(string $type, string $desc = '') {
  $err_array = constant("static::ERR");
  $base = 0;
  $offset = 0;
  if ( is_int($err_array[0]) ) {
    $base = $err_array[0];
    $offset = array_search($type, $err_array) ?: 0;
  }
  else {
    $offset = array_search($type, $err_array);
    if ( $offset === FALSE ) $offset = 0;
    else $offset++;
  }
  
  $code = $base + $offset;
  $msg = $type;

  $e = new \Exception($msg, $code);
  $e->desc = $desc;
  throw $e;
}

}


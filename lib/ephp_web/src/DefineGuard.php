<?php
namespace ephp\web;

class DefineGuard {

public static $defs = [];

public static function guard($word = null) {
  if ( is_null($word) ) {
    $bt = debug_backtrace();
    $word = sprintf('%s_%s', $bt[1]['file'], $bt[1]['line']);
  }
  if ( in_array($word, self::$defs) ) return false;
  else {
    self::$defs[] = $word;
    return true;
  }
}

public static function reset() {
  self::$defs = [];
}

}


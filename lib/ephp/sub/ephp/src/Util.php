<?php

namespace ephp;

class Util {

public static function calling_info($level = 0) {
  $level++;
  return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $level + 1)[$level];
}

public static function strtoid($str) {
  $id = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');


  $id = preg_replace('/[^a-zA-Z0-9-_,\s]/', '', strtolower($id));
  $id = preg_replace('/[\s,_-]+/', '-', $id);
  $id = preg_replace('/^-/', '', $id);
  $id = preg_replace('/-$/', '', $id);
  return $id;
}

}

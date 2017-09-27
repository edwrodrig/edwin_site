<?php
namespace ephp\web;

class DefineGuard {

public static function guard($word = null) {
  if ( is_null($word) ) {
    $word = Id::line(2);
  }
  if ( in_array($word, BuilderState::get()->define_guards_defs) ) return false;
  else {
     BuilderState::get()->define_guards_defs[] = $word;
    return true;
  }
}

public static function define($callable, $level = 0) {
  $id = Id::line($level + 1);
  if ( !isset(BuilderState::get()->define_guards_elems[$id]) )
    BuilderState::get()->define_guards_elems[$id] = ($callable)();
  return BuilderState::get()->define_guards_elems[$id];
}

}


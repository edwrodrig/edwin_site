<?php

namespace ephp\web;

class Id {
  
private static $seed_func = 0;
private static $seed_anim = 0;

static function t() { return sprintf("t%d", BuilderState::get()->id_seed_t++); }
static function c() { return sprintf("s%d", BuilderState::get()->id_seed_c++); }
static function func() { return sprintf("func_%d", self::$seed_func++); }
static function anim() { return sprintf("anim_%d", self::$seed_anim++); }
static function line($level = 0) {
  $bt = debug_backtrace();
  return sprintf('%s_%s', $bt[$level]['file'], $bt[$level]['line']);
}

}

<?php
namespace ephp\web {

class Styles {

private static $elems = [];

public static function define($callable, ...$args) {
  $level = empty($args) ? 0 : 1;
  $bt = debug_backtrace();
  $id = sprintf('%s_%s', $bt[$level]['file'], $bt[$level]['line']);
  if ( !isset(self::$elems[$id]) ) self::$elems[$id] = ($callable)(...$args);
  return self::$elems[$id];
}

public static function __callStatic($id, $args = []) {
  return self::call($id, null, ...$args);
}

public static function call($id, $callable, ...$args) {
  $id = str_replace('-', '_', $id);
  if ( !isset(self::$elems[$id]) ) {
    if ( isset($callable) ) {
      self::$elems[$id] = ($callable)(...$args);
    } else {
      $function_id = '\style\\' . $id;
      if ( function_exists($function_id) ){
        self::$elems[$id] = ($function_id)(...$args);
      } else return null;
    }
  }
  return self::$elems[$id];
}

public static function reset() {
  self::$elems = [];
}

}

}

namespace style {

use \ephp\web\Style;

function visible_small_only($width = '600px') {
  $media = "@media (min-width:$width)";
  return style('.', [$media => style(['display' => 'none !important']) ]);
}

function hidden_small($width = '600px') {
  $media = "@media (max-width:$width)";
  return style('.', [$media => style(['display' => 'none !important']) ]);
}

function layout_container_inside($max_width = '1000px') {
  return style('.', ['max-width' => $max_width, 'margin' => '0 auto', 'overflow-x' => 'hidden']);
}

function layout_responsive($responsive_width = '600px') {
  $media = "@media ( max-width:$responsive_width )";
  return style('.', [
            'display' => 'flex',
            $media => style(['flex-direction' => 'column']),
            '> *' => style([$media => style(['width' => '100% !important', 'min-width' => '0 !important']) ])
          ]);
}

function border_top_bar($radius = '0.5em', $style = 'solid') {
  return style('.', [
    'border-bottom-style' => $style,
    ':first-of-type' => style(['border-left-style' => $style, 'border-bottom-left-radius' => $radius]),
    ':last-of-type' => style(['border-right-style' => $style, 'border-bottom-right-radius' => $radius])
    ]);
}

function box_image() {
  return style_def([
    'background-size' => 'cover',
    'background-position' => 'center',
    'background-repeat' => 'no-repeat'
  ]);
}

function box_resume_container() {
  return style_def([
    'display' => 'flex',
    'overflow' => 'hidden',
    'padding' => '1em',
    '> *' => style(['overflow' => 'hidden'])
  ]);
}

}



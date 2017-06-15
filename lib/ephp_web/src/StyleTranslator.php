<?php
namespace ephp\web {

class StyleTranslator {

public $props = [];
public $transitions = [];

function __construct($p) { $this->add($p); }

function add($p) {
  foreach ( $p as $name => $value ) {
    $m_name = str_replace('-', '_',$name);
    $function_id = '\style\\props\\' . $m_name;
    if ( $m_name === 'trans' ) {
      $this->trans($value);
    } else if ( function_exists($function_id) ) {
      $this->add(($function_id)($value));
    } else {
      $this->props[$name] = $value;
    }
  }
}

function trans($arg) {
  foreach ( $arg as $name => $value ) {
    $this->transitions[$name] = $value;
  }
}

function __invoke() : string {
  $trans = [];
  foreach ( $this->transitions as $name => $value ) {
    $trans[] = sprintf('%s %s', $name ,$value);
  }
  if ( count($trans) > 0 ) $this->add(['transition' => implode(' ', $trans)]);

  $str = '';
  foreach ( $this->props as $name => $value ) {
    $str .= sprintf('%s:%s;', $name, $value);
  }
  return $str;
}

}

}

namespace style\props {

function layout($arg) {
  if ( $arg === 'row' ) {
    return ['display' => 'flex', 'flex-direction' => 'row'];
  }
  if ( $arg === 'column' ) {
    return ['display' => 'flex', 'flex-direction' => 'column'];
  }
  if ( $arg === 'row-center' ) {
    return ['layout' => 'row', 'justify-content' => 'center', 'flex-flow' => 'wrap'];
  }
  if ( $arg === 'row-right' ) {
    return ['layout' => 'row', 'justify-content' => 'flex-end'];
  }
}

function align($arg) {
  if ( $arg === 'center' ) {
    return ['text-align' => 'center', 'display' => 'flex', 'flex-direction' => 'column', 'justify-content' => 'center', 'overflow' => 'hidden'];
  } else return [];
}

function size($arg) {
  return ['width' => $arg, 'min-width' => $arg, 'height' => $arg];
}

function drop_shadow($arg) {
  $color = 'black';
  $blur = '2px';
  if ( is_string($arg) ) $color = $arg;
  else {
    $color = $arg['color'] ?? $color;
    $blur = $arg['blur'] ?? $blur;
  }
  return ['text-shadow' => sprintf('0 2px %s %s;', $blur, $color)];
}

function inner_glow($arg) {
  $color = 'black';
  $blur = '1em';
  if ( is_string($arg) ) $color = $arg;
  else {
    $color = $arg['color'] ?? $color;
    $blur = $arg['blur'] ?? $blur;
  }
  return ['box-shadow' => sprintf('inset 0 0 %s 0 %s;', $blur, $color)];
}

function box_glow($arg) {
  $color = 'black';
  $blur = '1em';
  if ( is_string($arg) ) $color = $arg;
  else {
    $color = $arg['color'] ?? $color;
    $blur = $arg['blur'] ?? $blur;
  }
  return ['box-shadow' => sprintf('0 0 %s 0 %s;', $blur, $color)];

}

function text_glow($arg) {
  $color = 'black';
  $blur = '4px';
  if ( is_string($arg) ) $color = $arg;
  else {
    $color = $arg['color'] ?? $color;
    $blur = $arg['blur'] ?? $blur;
  }
  return ['text-shadow' => sprintf('0 0 %s %s, 0 0 %s %s;', $blur, $color, $blur, $color)];
}

function bg_img($arg) {
  return ['background-image' => sprintf('url(%s)', $arg)];
}

function bg_cover() {
  return ['background-size' => 'cover', 'background-position' => 'center'];
}

function bg_img_fixed($arg) {
  return ['bg-img' => $arg, 'background-attachment' => 'fixed', 'bg-cover' => 'cover'];
}

function bg_color($arg) {
  return ['background-color' => $arg];
}

}



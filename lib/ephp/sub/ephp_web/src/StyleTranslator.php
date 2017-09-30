<?php
namespace ephp\web;

class StyleTranslator {

public $props = [];
public $transitions = [];

function __construct($p) { $this->add($p); }

function add($p) {
  foreach ( $p as $name => $value ) {
    if ( $name === 'trans' ) {
      $this->trans($value);
    } else if ( $name == 'bg-img' ) {
      $this->props['background-image'] = sprintf('url(%s)', $value);
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



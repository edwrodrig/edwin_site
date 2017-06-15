<?php
namespace ephp\web;

class Style {

public $selector = null;
private $prop = [];
private $sub = [];
private $parent = null;

private static $seed_id = 0;
private static $seed_class = 0;
private static $used_selector = [];

function __construct(...$args) {
  $this(...$args);
}

function __clone() {
  foreach ( $this->sub as $value ) {
    $cloned = clone $value;
    $cloned->parent = $this;
    $this->sub[$value->selector] = $cloned;
  }
}

function is_class() : bool {
  if ( !$this->is_top() ) return false;
  return $this->selector[0] === '.';
}

function is_anon() : bool { return empty($this->selector); }
function is_top() : bool {
  if ( $this->is_anon() ) return false;
  return !$this->is_sub();
}

function is_sub() : bool {
  if ( $this->is_anon() ) return false;
  return in_array($this->selector[0], ['>', ':', '@']);
}

function is_media() : bool {
  if ( $this->is_anon() ) return false;
  return $this->selector[0] === '@';
}

function print() {
  if ( !$this->is_top() ) return;
  if ( in_array($this->selector, self::$used_selector) ) return;
  self::$used_selector[] = $this->selector;
  $str = strval($this);
  if ( empty($str) ) return;
  echo '<style>', $this, '</style>';  
}

function __toString() : string {
  if ( $this->is_anon() ) {
    return $this->prop_str();
  } else {   
    $props = $this->prop_str();
    if ( !empty($props) ) {
      if ( $this->is_media() ) {
        $props = sprintf('%s{%s}}', $this->selector_str(), $props);
      } else {
        $props = sprintf('%s{%s}', $this->selector_str(), $props);
      }
    }
    return sprintf('%s%s', $props, $this->sub_str());
  }
}

function isset() : bool {
  if ( $this->is_anon() ) return !empty($this->prop);
  return true;
}

function class_str() : string {
  if ( !$this->is_class() ) return '';
  return substr($this->selector, 1);

}

private static function get_selector($arg) {
  if ( $arg === '#' ) return sprintf('#s%d', self::$seed_id++);
  if ( $arg === '.' ) return sprintf('.s%d', self::$seed_class++);
  return $arg;  
}

private function prop_str() : string {
  return (new StyleTranslator($this->prop))();
}

private function sub_str() : string {
  $str = '';

  foreach ( $this->sub as $value ) {
    $str .= $value;
  }

  return $str;

}

private function set_array(array $a) {
  foreach ( $a as $name => $value ) {
    if ( is_null($value) ) {
      unset($this->prop[$name]);
      unset($this->sub[$name]);
    } else if ( $value instanceof Style ) {
      if ( isset($this->sub[$name]) ) {
        $this->sub[$name]->set_style($value);
      } else {
        $cloned = clone $value;
        $cloned->selector = $name;
        $this->sub[$name] = $cloned;
        $cloned->parent = $this;
      }
    } else {
      $this->prop[$name] = $value;
    }
  }
}

private function set_style(Style $s) {
  $this->set_array($s->prop);
  $this->set_array($s->sub);
}

private function selector_str() : string {
  if ( empty($this->selector) ) return '';
  if ( isset($this->parent) ) {
    $selector = $this->selector;
    if ( $selector[0] === '@' ) return sprintf('%s{%s', $selector, $this->parent->selector_str());
    if ( $selector[0] === '>' ) $selector = ' ' . $selector;
    return sprintf('%s%s', $this->parent->selector_str(), $selector);
  }
  else return $this->selector;
}

function __invoke(...$args) {
  foreach ( $args as $arg ) {
    if ( is_string($arg) ) {
      if ( preg_match('/^[a-zA-Z]/', $arg) ) {
        $style = Styles::__callStatic($arg);
        if ( $style instanceof Style ) $this->set_style($style);
        else if ( is_array($style) ) $this(...$style);
      } else {
        $this->selector = self::get_selector($arg);   
      }
    }
    else if ( is_array($arg) ) $this->set_array($arg);
    else if ( $arg instanceof Style ) $this->set_style($arg);
  }
  return $this;
}

static function reset() {
  self::$seed_id = 0;
  self::$seed_class = 0;
  self::$used_selector = [];
  Styles::reset();
}

}



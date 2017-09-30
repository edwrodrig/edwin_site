<?php

namespace ephp\web;

class Js {

public $id;
public $elem;

function __construct($elem) {
  $this->elem = null;
  $this->id = null;

  if ( method_exists($elem, 'js_elem') ) {
    $this->elem = $elem;
  }
  else if ( method_exists($elem, 'html_id') ) {
    $this->id = $elem->html_id();
    if ( empty($this->id) ) throw new \Exception('Element has not id');
  }
  else 
    throw new \Exception('Element has not id');
}

function elem() {
  if ( is_null($this->id) )
    return $this->elem->js_elem();
  else
    return sprintf("document.getElementById('%s')", $this->id);
}

function hide() {
  return $this->elem() . '.style.display = "none";';
}

function show() {
  return $this->elem() . '.style.display = "";';
}

function toggle() {
  return "(function() { var e = " . $this->elem() . "; e.style.display = (e.style.display == 'none' ) ? '' : 'none'; })();";
}

function id() {
  if ( empty($this->id) ) throw new \Exception('Element has not instantiable id'); 
  return $this->id;
}

function __toString() {
  return $this->elem();
}

function __invoke(...$args) {
  return $this->elem() . '.' . sprintf(...$args);
}

}

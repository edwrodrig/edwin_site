<?php
namespace ephp\web;

class Template {

function __call($name, $args = []) {
  $c = new \ReflectionClass($this);
  if ( strpos($name, '__') !== 0 ) {
    if ( $c->hasProperty($name) ) {
      $this->{$name}->set(...$args);
    }
    return;
  }
  $method = substr($name, 2);

  $content = $args[0] ?? '';
  do {
    if ( $c->hasMethod($method) ) {
      $m = $c->getMethod($method);
      $c = $m->getDeclaringClass();
      ob_start();
      $m->invoke($this, $content);
      $content = ob_get_clean();
    }
  } while ( $c = $c->getParentClass() );

  echo $content;
}

function __toString() {
  ob_start();
  $this();
  return ob_get_clean();
}

}



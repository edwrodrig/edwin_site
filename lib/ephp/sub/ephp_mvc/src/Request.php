<?php
namespace ephp\mvc;

class Request {

protected $actions = [];
protected $filters = [];

function __construct() {;}

function retrieve($request) {
  $this->actions = $request->actions;
  $this->filters = $request->filters;
}

function add_action(...$actions) {
  $this->actions = array_merge($actions, $this->actions);
}

function add_filter(...$filters) {
  $this->filters = array_merge($filters, $this->filters);
}

function invoke_action($action_name, $params) {
  if ( is_null($action_name) ) Error::fire('ACTION_NOT_SPECIFIED');

  $action = $this->get_action($action_name);

  $params = self::params($action['method'], $params);
  $params = $this->apply_filters($params, $action['method']);

  return $action['method']->invokeArgs($action['action'], $params);
}

function apply_filters($params) {
  foreach ( $this->filters as $filter ) {
    $params = ($filter)($params);
  }
  return $params;
}

function get_comment() {
  foreach ( $this->actions as $actions ) {
    $class = new \ReflectionClass($actions);
    $comment = $class->getDocComment();
    if ( empty($comment) ) continue;
    return $comment;
  }
  return '';
}

function get_actions() {
  $methods = [];
  
  foreach ( $this->actions as $actions ) {
    $class = new \ReflectionClass($actions);
    foreach ( $class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method ) {
      if ( isset($methods[$method->name]) ) continue;
      $methods[$method->name] = true;
      yield $method->name => $method;
    }
  }
}

function get_action($action) {
  foreach ( $this->actions as $actions ) {
    $method = self::get_object_method($actions, $action);
    if ( !is_null($method) ) return ['action' => $actions, 'method' => $method];
  }
  Error::fire('ACTION_NOT_AVAILABLE');
}

static function get_object_method($object, $action) {
  $class = new \ReflectionClass($object);
  if ( !$class->hasMethod($action) ) return null;
  $method = $class->getMethod($action);
  if ( !$method->isPublic() ) return null;
  return $method;
}

static function params(\ReflectionMethod $method, array $args) {
  $params = [];
  foreach ( $method->getParameters() as $param ) {
    $name = $param->getName();
    if ( isset($args[$name]) )
      $params[$name] = $args[$name];
    else if ( isset($args[$param->getPosition()]) )
      $params[$name] = $args[$param->getPosition()];
    else if ( $param->isDefaultValueAvailable() )
      $params[$name] = $param->getDefaultValue();
    else
      Error::fire('ACTION_PARAM_MISSING', $param->name);

    if ( $param->hasType() ) {
      $type = gettype($params[$name]);
      if ( $type == 'boolean' ) $type = 'bool';
      if ( strval($param->getType()) != $type ) {
        Error::fire('ACTION_PARAM_TYPE_MISMATCH', $param->name);
      }
    }
  }
  return $params;
} 

}



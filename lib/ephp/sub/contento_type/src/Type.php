<?php
namespace contento;

require_once(__DIR__ . '/TypeEnum.php');
require_once(__DIR__ . '/TypeObject.php');
require_once(__DIR__ . '/TypeId.php');
require_once(__DIR__ . '/TypeString.php');
require_once(__DIR__ . '/TypeRef.php');
require_once(__DIR__ . '/TypeList.php');
require_once(__DIR__ . '/TypeImageRef.php');
require_once(__DIR__ . '/TypeDate.php');
require_once(__DIR__ . '/TypeDateTime.php');
require_once(__DIR__ . '/TypeTime.php');

class Type {

public $data;

function __construct($data) {
  $this->data = $data;
}

function type() { return $this->data['type'] ?? 'string'; }

function name() { return $this->data['name'] ?? null; }

function field() { return $this->data['field'] ?? null; }

function display() { return $this->data['display'] ?? false; }

function displayable() { return $this->display(); }

function required() { return $this->data['required'] ?? false; }

function default_value() { return $this->data['default'] ?? null; }

function label() { return $this->data['label'] ?? $this->data['field'] ?? $this->data['name'] ?? ''; }

function json() { return json_encode($this->data); }

function routes() { return ['']; }

function is_ref() { return false; }

static function create($data) {
  if ( $data['type'] == 'object' )
    return new TypeObject($data);
  else if ( $data['type'] == 'id' )
    return new TypeId($data);
  else if ( $data['type'] == 'collection' )
    return self::create($data['elem']);
  else if ( $data['type'] == 'string' )
    return new TypeString($data);
  else if ( $data['type'] == 'ref' )
    return new TypeRef($data);
  else if ( $data['type'] == 'list' )
    return new TypeList($data);
  else if ( $data['type'] == 'enum' )
    return new TypeEnum($data);
  else if ( $data['type'] == 'image_ref' )
    return new TypeImageRef($data);
  else if ( $data['type'] == 'date' )
    return new TypeDate($data);
  else if ( $data['type'] == 'datetime' )
    return new TypeDateTime($data);
  else if ( $data['type'] == 'time' )
    return new TypeTime($data);
  else 
    return new Type($data);
}

function __invoke($data) {
  return new Value($data, $this);
}

}



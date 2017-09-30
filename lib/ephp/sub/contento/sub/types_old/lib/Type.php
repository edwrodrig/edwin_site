<?php
namespace contento;

class Type {

public $data;

function __construct($data) {
  $this->data = $data;
}

function name() { return $this->data['name'] ?? null; }

function field() { return $this->data['field'] ?? null; }

function display() { return $this->data['display'] ?? false; }

function create($data) {
  if ( $data['type'] == 'object' )
    return new \contento\type\Obj($data);
  else if ( $data['type'] == 'id' )
    return new \contento\type\Id($data);
  else if ( $data['type'] == 'collection' )
    return self::create($data['elem']);
  else if ( $data['type'] == 'string' )
    return new \contento\type\Str($data);
  else if ( $data['type'] == 'ref' )
    return new \contento\type\Ref($data);
  else if ( $data['type'] == 'list' )
    return new \contento\type\Lista($data);
  else 
    return new \contento\Type($data);
}

function __invoke($data) {
  return new \contento\Value($data, $this);
}

}



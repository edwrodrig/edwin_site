<?php
namespace contento;

class TypeId extends Type {

public $data;

function __construct($data) {
  parent::__construct($data);
}

function fields() {
  return $this->data['fields'] ?? [];
}

function __invoke($data) {
  return new ValueId($data, $this);
}

}

class ValueId extends Value {

public $parentObject = null;

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function __invoke() {
  $id = $this->data ?? '';
  if ( isset($this->parentObject) && empty($id) ) {
    $id = '';
    foreach ( $this->type->fields() as $field ) {
      $id .= '-' . strval($this->parentObject->get_field($field) ?? '');
    }
  }
  
  $id = \ephp\Util::strtoid($id);
  if ( empty($id) ) return 'id-element-' . preg_replace('/[^0-9]/', '', microtime());
  return $id;
}

}

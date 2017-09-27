<?php
namespace contento\type {

class Id extends \contento\Type {

public $data;

function __construct($data) {
  parent::__construct($data);
}

function fields() {
  return $this->data['fields'] ?? [];
}

function __invoke($data) {
  return new \contento\value\Id($data, $this);
}

}

}

namespace contento\value {

class Id extends \contento\Value {

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
  
  $id = strtr(utf8_decode($id), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

  
  $id = preg_replace('/[^a-zA-Z0-9-_,\s]/', '', strtolower($id));
  $id = preg_replace('/[\s,_-]+/', '-', $id);
  $id = preg_replace('/^-/', '', $id);
  $id = preg_replace('/-$/', '', $id);
  if ( empty($id) ) return 'id-element-' . preg_replace('/[^0-9]/', '', microtime());
  return $id;
}

}

}

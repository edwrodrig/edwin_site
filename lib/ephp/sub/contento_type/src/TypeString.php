<?php
namespace contento;

class TypeString extends Type {

function __construct($data) {
  parent::__construct($data);
}

function __invoke($data) {
  return new ValueString($data, $this);
}

function displayable() {
  if ( $this->style() == 'rich' ) return false;
  else return parent::displayable();
}

function style() {
  return $this->data['style'] ?? 'text';
}


function trim() {
  return $this->data['trim'] ?? false;
}

function translatable() {
  return $this->data['tr'] ?? false;
}

function validator() {
  return $this->data['validator'] ?? false;
}

}


class ValueString extends Value {

function __construct($data, $type) {
  parent::__construct($data, $type);
}

function __toString() {
  if ( is_array($this->data) ) {
    foreach ( $this->data as $value ) return $value;
    return '';
  } else {
    return $this->data;
  }
}

function set($value) {
  $type = $this->type;
  $normalize = function(&$value) {
    if ( $this->type->trim() ) $value = trim($value);
    if ( empty($value) ) $value = null;
  };

  if ( $this->type->translatable() ) {
    if ( !is_array($value) ) $value = [];
    foreach ( \ephp\Format::$langs as $lang ) {
      if ( !isset($value[$lang['value']]) ) $value[$lang['value']] = null;
      $normalize($value[$lang['value']]);
    }
  } else {
    $normalize($value);
  }

  parent::set($value);

}

function validate($value) {
  parent::validate($value);

  $validate = function($value) {
    if ( $regex = $this->type->validator() ) {
      if ( !preg_match($regex, $value) ) {
        $this->fire('STRING_INVALID');
      }
    }
  };

  if ( $this->type->translatable() ) {
    if ( !is_array($value) ) $this->fire(sprintf('NOT AN ARRAY [%s] => [%s]', $this->type->field(), json_encode($value, JSON_PRETTY_PRINT)));
    foreach ( \ephp\Format::$langs as $lang ) {
      if ( array_key_exists($lang['value'], $value) ) {
        $validate($value[$lang['value']]);
      } else {
        $this->fire(sprintf('STRING_INVALID [%s] => [%s]', $this->type->field(), json_encode($value, JSON_PRETTY_PRINT)));
      }
    }
  } else {
    $validate($value);
  }
}

}


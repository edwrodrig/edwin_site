<?php
namespace contento;

class CollectionBuilder {

public $types = [];
public $collections = [];

function add($data) {
  if ( $data['type'] == 'collection' ) $this->collections[$data['name']] = $data;
  else $this->types[$data['name']] = $data;
}

function resolve_type($type) {
  if ( $type['type'] === 'custom' ) {
    return $this->resolve_type_custom($type);
  } else if ( $type['type'] === 'collection' ) {
    return $this->resolve_type_collection($type);
  } else if ( $type['type'] === 'object' ) {
    return $this->resolve_type_object($type);
  } else if ( $type['type'] === 'list' ) {
    return $this->resolve_type_list($type);
  }
  return $type;
}

function resolve_type_custom($type) {
  $parent_type = $this->resolve_type($this->types[$type['type_name']]);
  
  foreach ( $type as $key => $value ) {
    if ( in_array($key, ['type', 'type_name', 'fields']) ) continue;
    $parent_type[$key] = $type[$key];
  }

  if ( isset($type['field']) ) unset($parent_type['name']);

  if ( in_array($parent_type['type'], ['custom', 'object'])) {
    if (  !isset($parent_type['fields']) ) $parent_type['fields'] = [];

    $fields = [];
    foreach ( $parent_type['fields'] as $index => $field ) {
      $fields[$field['field']] = $index;
    }

    foreach ( $type['fields'] ?? [] as $field ) {
      $index = $fields[$field['field']] ?? null;
      if ( is_null($index) ) {
        $parent_type['fields'][] = $field;
      } else { 
        $parent_type['fields'][$index] = $field;
      }
    }
  }
  return $this->resolve_type($parent_type);
}

function resolve_type_object($type) {
  foreach ( $type['fields'] as $index => $value ) {
    $type['fields'][$index] = $this->resolve_type($value);
  }
  return $type;
}

function resolve_type_list($type) {
  $type['elem'] = $this->resolve_type($type['elem']);
  return $type;
}

function resolve_type_collection($type) {
  $type['elem'] = $this->resolve_type($type['elem']);
  $type['elem']['name'] = $type['elem']['name'] ?? $type['name'];
  $type['elem']['fields'][] = ['field' => 'id', 'type' => 'id', 'display' => true, 'fields' => $type['elem']['id'] ?? []];
  return $type;
}

}

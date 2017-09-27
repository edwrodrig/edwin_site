<?php
namespace contento\data;

class Model {

public $db;

function get_type(string $collection_name) {
  $collection = $this->db->get('collection_by_name', $collection_name);
  $type = \contento\Type::create($collection['data']);
  return $type;
}

function collection_add($data) {
  $this->db->call('collection_add', $data['name'], json_encode($data));
  return true;
}

function collection_delete_by() {
  $this->db->call('collection_delete_by');
}

function collection_by() {
  return iterator_to_array($this->db->for_each('collection_by'));
}

function collection_by_name(string $name) {
  if ( $r = $this->db->get('collection_by_name', $name) ) {
    return $r;
  } else Error::fire('COLLECTION_NOT_EXISTS');
}

function data_exists(string $name, string $collection_name) {
  if ( $r = $this->db->get('data_count_by_name_collection', $name, $collection_name) ) {
    return intval($r['number']) > 0;
  } else Error::fire('BASE');
}

function get_existant_id(string $seed_id, string $collection_name) {
  $current_id = $seed_id;
  $id = 1;
  while ( $this->data_exists($current_id, $collection_name) ) {
    $current_id = $seed_id . '-' . strval(++$id);
  }
  return $current_id;
}


function data_add($data, string $collection_name) {
  $type = $this->get_type($collection_name);
  $data = $type($data)('full');
  $data['id'] = $this->get_existant_id($data['id'] ?? '', $collection_name);
  $this->db->call('data_add', $data['id'], $collection_name, json_encode($data, JSON_PRETTY_PRINT));
  return ['id' => $data['id']];
}

function data_update($data, string $name, string $collection_name) {
  $type = $this->get_type($collection_name);
  $data = $type($data)('full');
  if ( $data['id'] != $name ) {
    $data['id'] = $this->get_existant_id($data['id'], $collection_name);
  }
  $this->db->call('data_update', $data['id'], json_encode($data, JSON_PRETTY_PRINT), $name, $collection_name);
  
  $this->data_update_ref($collection_name, $name, $data['id']);

  return ['id' => $data['id']];
}

function data_update_ref($collection_name, $old_id, $new_id) {
  if ( $old_id == $new_id ) return;
  foreach ( $this->collection_by() as $collection ) {
    $type = \contento\Type::create($collection['data']);
    foreach ( $this->db->for_each('data_by_collection', $collection['name']) as $item) {
      $value = $type($item['data']);
      if ( $value->update_ref($collection_name, $old_id, $new_id) ) {
        $this->data_update($value->data, $item['data']['id'], $collection['name']);
      } 
    }
  }
}

function data_delete(string $name, string $collection) {
  $this->db->call('data_delete', $name, $collection);
  return true;
}

function data_by_collection(string $collection_name, bool $short = true, bool $metadata = true) {
  $type = $this->get_type($collection_name);
  $ret = [];
  foreach ( $this->db->for_each('data_by_collection', $collection_name) as $data) {
    $data['data'] = $type($data['data'])($short ? 'display' : 'full');
    $ret[] = $metadata ? $data : $data['data'];
  }
  return $ret;
}

function data_by_name_collection(string $name, string $collection_name, bool $short = false) {
  $type = $this->get_type($collection_name);
  if ( $r = $this->db->get('data_by_name_collection', $name, $collection_name) ) {
    $r['data'] = $type($r['data'])($short ? 'display' : 'full');
    return $r;
  } else Error::fire('DATA_NOT_EXISTS');
}

function collection_check(string $collection_name) {
  $type = $this->get_type($collection_name);
  foreach ( $this->db->for_each('data_by_collection', $collection_name) as $data) {
    try {
      $data['data'] = $type($data['data'])('full');
    } catch ( \Exception $e ) {
      $e->contento_data = $data['data'];
      $e->contento_collection = $collection_name;
      throw $e;
    }
  }
}

function data_raw_by_name_collection(string $name, string $collection_name) {
  if ( $r = $this->db->get('data_by_name_collection', $name, $collection_name) ) {
    return $r['data'];
  } else Error::fire('DATA_NOT_EXISTS'); 
}

}





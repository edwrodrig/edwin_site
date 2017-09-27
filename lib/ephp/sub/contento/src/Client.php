<?php

namespace contento;

class Client extends \ephp\usac\Client {

public function collections() {
  $resp = $this->request(['action' => 'contento_collection_by', 'session' => $this->session]);
  $ret = [];
  
  foreach ( $resp as $data ) {
    $ret[$data['data']['name']] = $data['data'];
  }

  return $ret;
}

public function collection($collection) {
  $resp = $this->request(['action' => 'contento_data_by_collection', 'session' => $this->session, 'collection' => $collection,'short' => false]);
  $ret = [];
  foreach ( $resp as $data ) {
    $ret[$data['data']['id']] = $data['data'];
  }
  return $ret;
}

public function get_data($name, $collection) {
  $resp = $this->request(['action' => 'contento_data_by_name_collection', 'session' => $this->session, 'name' => $name, 'collection' => $collection, 'short' => false]);
  return $resp;
}

public function update_data($data, $collection) {
  $resp = $this->request(['action' => 'contento_data_update', 'session' => $this->session, 'collection' => $collection, 'name' => $data['id'], 'data' => json_encode($data, JSON_PRETTY_PRINT)]);
  return $resp;
}

public function add_data($data, $collection) {
  $resp = $this->request(['action' => 'contento_data_add', 'session' => $this->session, 'collection' => $collection, 'data' => json_encode($data, JSON_PRETTY_PRINT)]);
}

public function images() {
  $resp = $this->request(['action' => 'image_by', 'session' => $this->session]);
  $ret = [];

  foreach ( $resp as $data ) {
    $ret[$data['data']['id']] = $data;
  }
  return $ret;
}

}
?>

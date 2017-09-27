<?php

namespace contento;

class Client {

private $service;
private $session;
public $response;

public function __construct($service) {
  $this->service = $service;
}

public function request($data) {
  $context = stream_context_create(['http' =>
    [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => json_encode($data)
    ]
  ]);
  $r = json_decode(file_get_contents($this->service, false, $context), true);
  if ( ($r['status'] ??  -1) >= 0 ) {
    return $r['data'];
  } else {
    var_dump($r);
    throw new \Exception('Request error');
  }
}

public function login($user, $pass) {
  $resp = $this->request(['action' => 'usac_user_login', 'username' => $user, 'password' => $pass]);
  $this->session = $resp; 
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

}
?>

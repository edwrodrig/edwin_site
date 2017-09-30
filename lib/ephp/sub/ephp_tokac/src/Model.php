<?php
namespace ephp\tokac;

class Model {

public $db;
public $request;

function __construct() {
  $this->request = new \ephp\mvc\RequestAssoc;
}

function entry_create(array $private_data, array $public_data, int $duration = 10) {
  $token = uniqid("", true);
  $private_data['token'] = $token;
  $public_data['token'] = $token;
  $this->db->call('entry_create', $token, json_encode($private_data), json_encode($public_data), $duration);
  return $public_data;
}

function entry_check(string $token) {
  if ( $r = $this->db->get('entry_by_token', $token) ) {
    Error::fire_if_expired($r);
    return json_decode($r['public_data'], true);
  } else Error::fire('ENTRY_NOT_EXISTS');
}

function entry_execute(string $token, array $user_data) {
  if ( $r = $this->db->get('entry_by_token', $token) ) {
    Error::fire_if_expired($r);
    $args = array_replace_recursive(
              json_decode($r['public_data'], true),
              $user_data,
              json_decode($r['private_data'], true));
    $result = $this->invoke_action($args);
    if ( $result ) {
      $this->db->call('entry_remove_by_id', $r['id']);
    }
    return $result;
  } else Error::fire('ENTRY_NOT_EXISTS');
}

function invoke_action($args) {
  return ($this->request)($args);
}

}


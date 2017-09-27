<?php
namespace ephp\usac;

class Model {

const USER_TYPE_REGISTERED = 1;
const USER_TYPE_GUEST = 2;

public $db;
public $tokac_model;

function session_new($id) {
  $session = uniqid("", true);
  $this->db->call('session_new', $session, $id);
  return $session;
}

function user_create($username, $password, $mail) {
  $this->db->call('user_create', $username, self::passwd($password), $mail, self::USER_TYPE_REGISTERED);
  return true;
}

function user_by_name(string $name) {
  return $this->db->get('user_by_name', $name);
}

function user_by_mail(string $mail) {
  return $this->db->get('user_by_mail', $mail);
}

function user_by_name_mail(string $user_or_mail) {
  return $this->db->get('user_by_name_mail', $user_or_mail, $user_or_mail);
}

function user_by_session($session) {
  return $this->db->get('user_by_session', $session);
}

function user_login($username, $password) {
  if ( $r = $this->db->get('user_by_name', $username) ) {
    if ( $r['type'] != self::USER_TYPE_REGISTERED ) Error::fire('USER_NOT_EXISTS');
    if ( !password_verify($password, $r['password']) ) Error::fire('WRONG_PASSWORD');
    if ( !empty($r['session']) )
      return [
        'username' => $username,
        'session' => $r['session']
      ];
    else
      return [
        'username' => $username,
        'session' => $this->session_new($r['id'])
      ];
  } else Error::fire('USER_NOT_EXISTS');
}

function user_login_guest() {
  $username = uniqid('guest_');
  $this->db->call('user_create', $username, '', null, self::USER_TYPE_GUEST);
  if ( $r = $this->db->get('user_by_name', $username) ) {
    return [
      'username' => $username,
      'session' => $this->session_new($r['id'])
    ];
  } else Error::fire('USER_NOT_EXISTS');
}

function session_logout($session) {
  $this->db->get('session_logout', $session);
  return true;
}

function user_request_signin(string $mail) {
  if ( $r = $this->user_by_mail($mail) ) Error::fire('MAIL_ALREADY_REGISTERED'); 

  return $this->tokac_model->entry_create(
    ['action' => 'user_signin', 'mail' => $mail],
    ['mail' => $mail]);
}

function user_request_change_password(string $username_or_mail) {
  if ( $r = $this->db->get('user_by_name_mail', $username_or_mail, $username_or_mail) ) {
    return $this->tokac_model->entry_create(
      ['action' => 'user_change_password', 'username' => $r['name']],
      ['username' => $r['name'], 'mail' => $r['mail']]);
  } else Error::fire('USER_NOT_EXISTS');
}

function user_change_password(string $username, string $password) {
  $this->db->get('user_change_password_by_name', self::passwd($password), $username);
  return true;
}

function user_request_change_mail(string $username, string $mail) {
  if ( $r = $this->db->get('user_by_mail', $mail) ) Error::fire('MAIL_ALREADY_REGISTERED');
  if ( $r = $this->db->get('user_by_name', $username) ) {
    return $this->tokac_model->entry_create(
      ['action' => 'user_change_mail', 'username' => $username, 'mail' => $mail],
      ['username' => $username, 'mail' => $mail]);
  } else Error::fire('USER_NOT_EXISTS');
}

function user_change_mail(string $username, string $mail) {
  $this->db->get('user_change_mail_by_name', $mail, $username);
  return true;
}

static protected function passwd($password) {
  return password_hash($password, PASSWORD_BCRYPT);
}

}



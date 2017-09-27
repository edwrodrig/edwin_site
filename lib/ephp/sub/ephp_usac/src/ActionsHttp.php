<?php
namespace ephp\usac;

class ActionsHttp {

public $actions_mail_request;
public $user_login_guest_enabled = true;
public $user_request_signin_enabled = true;


function user_login(string $username, string $password) {
  return $this->usac_model->user_login($username, $password);  
}

function user_login_guest() {
  if ( !$this->user_login_guest_enabled )
    \ephp\mvc\Error::fire('ACTION_NOT_AVAILABLE');

  return $this->usac_model->user_login_guest();
}

function session_logout($session) {
  return $this->usac_model->session_logout($session['session']);
}

function session_check($session) {
  return true;
}

function session_username($session) {
  return $session['name'];
}

function user_request_signin(string $mail) {
  if ( !$this->user_request_signin_enabled )
    \ephp\mvc\Error::fire('ACTION_NOT_AVAILABLE');

  return $this->actions_mail_request->user_request_signin($mail);
}

function user_request_change_password(string $user_or_mail) {
  return $this->actions_mail_request->user_request_change_password($user_or_mail);
}

function session_request_change_mail($session, $mail) {
  return $this->actions_mail_request->user_request_change_mail($session['name'], $mail);
}

}


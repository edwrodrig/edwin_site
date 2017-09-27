<?php
namespace ephp\usac;

class ActionsTokac {

public $usac_model;

function user_signin(string $username, string $password, string $mail) {
  return $this->usac_model->user_create($username, $password, $mail);
}

function user_change_password(string $username, string $password) {
  return $this->usac_model->user_change_password($username, $password);
}

function user_change_mail(string $username, string $mail) {
  return $this->usac_model->user_change_mail($username, $mail);
}

}


<?php
namespace ephp\usac;

class ActionsConsole {

public $usac_model;

/**
 * @desc Create an user account
 * @param username Username
 * @param password Password for the username
 * @param mail User mail
 */
function user_create($username, $password, $mail) {
  return $this->usac_model->user_create($username, $password, $mail);
}

}

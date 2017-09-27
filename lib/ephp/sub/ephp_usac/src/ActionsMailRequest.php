<?php
namespace ephp\usac;

class ActionsMailRequest {

public $usac_model;
public $mail_sender;

/**
 * @desc Send a sign in request to mail
 * @param mail User mail
 */
function user_request_signin(string $mail, $lang = null) {
  $r = $this->usac_model->user_request_signin($mail);
  \ephp\Format::set_lang($lang);
  $this->mail_sender->user_request_signin($r);
  return true;
}

/**
 * @desc Send a change password request
 * @param user_or_mail the mail or username of the user
 */
function user_request_change_password(string $user_or_mail, $lang = null) {
  $r = $this->usac_model->user_request_change_password($user_or_mail);
  \ephp\Format::set_lang($lang);
  $this->mail_sender->user_request_change_password($r);
  return true;
}

/**
 * @desc Send a request to change mail
 * @param username Username to change mail
 * @param mail New mail of the user
 */
function user_request_change_mail(string $username, string $mail, $lang = null) {
  $r = $this->usac_model->user_request_change_mail($username, $mail);
  \ephp\Format::set_lang($lang);
  $this->mail_sender->user_request_change_mail($r);
  return true;
}

}


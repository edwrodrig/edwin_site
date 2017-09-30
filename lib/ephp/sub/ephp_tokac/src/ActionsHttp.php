<?php
namespace ephp\tokac;

class ActionsHttp {

public $model;

function tokac_entry_check(string $token) {
  return $this->model->entry_check($token);
}

function tokac_entry_execute(string $token, array $user_data) {
  return $this->model->entry_execute($token, $user_data);
}

}





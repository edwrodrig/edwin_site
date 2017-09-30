<?php

namespace ephp\tokac;

class Loader extends \ephp\mvc\Loader {

public $tokac;

function __construct() {
  parent::__construct();
  $this->tokac = new \stdClass();
}

function init_tokac() {
  $this->tokac->db = new \ephp\tokac\Db;
  $this->tokac->db->pdo = $this->tokac->pdo;

  $this->tokac->model = new \ephp\tokac\Model;
  $this->tokac->model->db = $this->tokac->db;
  $this->tokac->request = $this->tokac->model->request;
}

function http() {
  parent::http();

  $action_http = new \ephp\tokac\ActionsHttp;
  $action_http->model = $this->tokac->model;

  $this->request->add_action($action_http);

}

}

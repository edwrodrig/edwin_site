<?php

namespace ephp\usac;

class Loader extends \ephp\tokac\Loader {

public $usac;

function __construct() {
  parent::__construct();
  $this->usac = new \stdClass();
}

function default_config() {
  $config = parent::default_config();
  $config['usac'] = [
    'db' => 'usac.db',
    'user_login_guest_enabled' => false,
    'user_request_signin_enabled' => false,
    'mail' => [
      'page_url' => 'http://localhost:8080',
      'from_text' => 'User account system'
    ]
  ];

  return $config;
}

function init_databases() {
  $db_file = $this->config['usac']['db'];
  $this->usac->pdo = \ephp\db\Db::sqlite($db_file);
  $this->tokac->pdo = $this->usac->pdo;
}

function init_usac() {
  $this->init_databases();
  $this->init_tokac();
  $this->init_mail();

  $this->usac->db = new \ephp\usac\Db;
  $this->usac->db->pdo = $this->usac->pdo;

  $this->usac->model = new \ephp\usac\Model;
  $this->usac->model->db = $this->usac->db;
  $this->usac->model->tokac_model = $this->tokac->model;

  $mail_templates = new \ephp\usac\MailTemplates;
  $mail_templates->page_url = $this->config['usac']['mail']['page_url'];
  $mail_templates->from_text = $this->config['usac']['mail']['from_text'];

  $this->mail->sender->add_action($mail_templates);

  $this->usac->actions_mail_request = new \ephp\usac\ActionsMailRequest;
  $this->usac->actions_mail_request->usac_model = $this->usac->model;
  $this->usac->actions_mail_request->mail_sender = $this->mail->sender;

}

function http() {
  $this->init_usac();
  
  $action_http = new \ephp\usac\ActionsHttp;
  $action_http->usac_model = $this->usac->model;
  $action_http->actions_mail_request = $this->usac->actions_mail_request;
  $action_http->user_login_guest_enabled = $this->config['usac']['user_login_guest_enabled'];
  $action_http->user_request_signin_enabled = $this->config['usac']['user_request_signin_enabled'];

  $this->request->add_action($action_http);
  
  $filter_session = new \ephp\usac\FilterSession;
  $filter_session->usac_model = $this->usac->model;
  $this->request->add_filter($filter_session);

  parent::http();

  $action_tokac = new \ephp\usac\ActionsTokac;
  $action_tokac->usac_model = $this->usac->model;
  $this->tokac->request->add_action($action_tokac);
}

function console() {
  if ( file_exists($this->config['usac']['db']) ) {
    $this->console_normal();
  } else {
    $this->console_install();
  }
}

function console_normal() {
  parent::console();
  $this->init_usac();

  $console = new \ephp\usac\ActionsConsole;
  $console->usac_model = $this->usac->model;

  $this->request->add_action($this->usac->actions_mail_request);
  $this->request->add_action($console);

}

function console_install() {
  $console = new \ephp\usac\ActionsConsoleInstall;
  $console->db_file = $this->config['usac']['db'];

  $this->request->add_action($console);
}

}

<?php
namespace ephp\mvc;

class Loader {

protected $config;
public $request;
public $response;
protected $mail;

static function is_called_from_console() {
  return php_sapi_name() === 'cli';
}

function __construct() {
  $this->config = $this->default_config();
}

function get_config() { return $this->config; }

function init_mail() {
  $this->mail = new \stdClass();
  $this->mail->sender = new \ephp\mvc\MailSender($this->config['mail']);
}

function init_console() {
  $this->response = new Response;
  $this->request = new RequestConsole;
  $this->response->request = $this->request;
  $this->console();
}

function console() {
  $this->init_mail();
  $action = new \ephp\mvc\ActionMailTest();
  $action->mail_sender = $this->mail->sender;
  $this->request->add_action($action);
}

function init_http() {
  $this->response = new ResponseHttp;
  $this->request = new RequestHttp;
  $this->response->request = $this->request;
  $this->response->request->default_input = $this->config['http']['default_input'];

  $this->response->error_logging_enabled = $this->config['error_logging_enabled'];
  $this->response->access_control_allow_origin = $this->config['http']['access_control_allow_origin'];
  $this->http();
}

function http() {}

function default_config() {
  return [
    'console_enabled' => true,
    'error_logging_enabled' => false,
    'access_control_origin' => '*',
    'http' => [
      'default_input' => 'php://input',
      'access_control_allow_origin'  => '*'
    ],
    'mail' => [
      'host' => 'ssl://smtp.gmail.com',
      'port' => 465,
      'username' => 'some_mail@mail.com',
      'password' => 'some_password'
    ]
  ];
}

function set_config($config) {
  if ( is_string($config) && file_exists($config) ) {
    $config = json_decode(file_get_contents($config), true);
  }

  if ( is_array($config) ) {
    $this->config = array_replace_recursive($this->config, $config);
  }
}

function init_actions() {
  if ( self::is_called_from_console() && $this->config['console_enabled'] )
    $this->init_console();
  else
    $this->init_http();

  return $this->response;
}

function __invoke() {
  if ( !isset($this->response) ) $this->init_actions();
  return ($this->response)();
}

}
 



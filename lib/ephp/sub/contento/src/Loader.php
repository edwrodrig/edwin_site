<?php
namespace contento;

class Loader extends \ephp\usac\Loader {

public $contento;

function __construct() {
  parent::__construct();

  $this->contento = new \stdClass();
}

function get_contento_data($collection) {
  return $this->contento->data->model->data_by_collection($collection, false, false);
}

function default_config() {
  $config = parent::default_config();
  $config['contento'] = [
    'data_dir' => 'data/contento',
    'page_url' => 'http://localhost:8081/contento.php',
    'site' => [
      'lang' => 'es'
    ]
  ];
  return $config;
}

function init_databases() {
  parent::init_databases();
  $this->contento->pdo = $this->usac->pdo;
}

function init_contento() {
  $this->contento->data = new \stdClass();
  $this->contento->data->db = new \contento\data\Db;
  $this->contento->data->db->pdo = $this->contento->pdo;

  $this->contento->data->model = new \contento\data\Model;
  $this->contento->data->model->db = $this->contento->data->db;

  $this->contento->image = new \stdClass();
  $this->contento->image->db = new \contento\image\Db;
  $this->contento->image->db->pdo = $this->contento->pdo;

  $this->contento->image->model = new \contento\image\Model;
  $this->contento->image->model->db = $this->contento->image->db;
  $this->contento->image->model->file_dir = $this->config['contento']['data_dir'];
  
}

function http() {
  parent::http();

  $this->init_contento();

  $action_http = new \contento\data\ActionsHttp;
  $action_http->data_model = $this->contento->data->model;
 
  $this->request->add_action($action_http);

  $action_http = new \contento\image\ActionsHttp;
  $action_http->image_model = $this->contento->image->model;
  
  $this->request->add_action($action_http);

}

function console_normal() {
  parent::console_normal();

  $this->init_contento();
  $console = new \contento\ActionsConsole;
  $console->default_types_folder = $this->config['contento']['type_dir'] ?? null;
  $console->data_model = $this->contento->data->model;

  $this->request->add_action($console);
}
  

function console_install() {
  $console = new \contento\ActionsConsoleInstall;
  $console->db_file = $this->config['usac']['db'];
  $console->data_dir = $this->config['contento']['data_dir'];
  $this->request->add_action($console);
}

}

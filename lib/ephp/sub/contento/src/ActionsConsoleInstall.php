<?php
namespace contento;

/**
 * CONTENTO v0.1
 * Content Manager
 * by Edwin Rodríguez
 */
class ActionsConsoleInstall {

public $db_file;
public $data_dir;

/**
 * @desc Configure the server interactively 
 */
function configure() {
  echo "Settings up database...\n";

  @mkdir(dirname($this->db_file), 0777, true);

  $pdo = \ephp\db\Db::sqlite($this->db_file);

  $tokac_db = new \ephp\tokac\Db;
  $usac_db = new \ephp\usac\Db;
  $contento_db_data = new \contento\data\Db;
  $contento_db_image = new \contento\image\Db;

  $tokac_db->pdo = $pdo;
  $usac_db->pdo = $pdo;
  $contento_db_data->pdo = $pdo;
  $contento_db_image->pdo = $pdo;

  $tokac_db->create();
  $usac_db->create();
  $contento_db_image->create();
  $contento_db_data->create();

  printf("Database[%s] created.\n", $this->db_file);

  $dirs = [
    $this->data_dir . DIRECTORY_SEPARATOR . 'images'
  ];

  foreach ( $dirs as $dir ) {
    if ( !is_dir($dir) ) {
      mkdir($dir, 0777, true);
    }
  }
  
  printf("Data folder[%s] created.\n", $this->data_dir);
}

}


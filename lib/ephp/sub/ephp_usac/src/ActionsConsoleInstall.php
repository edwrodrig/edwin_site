<?php
namespace ephp\usac;

class ActionsConsoleInstall {

public $db_file;

/**
 * @desc Configure the serve interactively
 */
function configure() {
  echo "Settings up database...\n";

  $pdo = \ephp\db\Db::sqlite($this->db_file);

  $tokac_db = new \ephp\tokac\Db;
  $usac_db = new \ephp\usac\Db;
  $tokac_db->pdo = $pdo;
  $usac_db->pdo = $pdo;

  $tokac_db->create();
  $usac_db->create();
 
  printf("Database[%s] created.\n", $this->db_file);
}

}

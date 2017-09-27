<?php
namespace ephp\tokac;

class Db extends \ephp\db\Db {

const create = <<<EOT
CREATE TABLE IF NOT EXISTS tokac_entries(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  token TEXT UNIQUE NOT NULL,
  private_data TEXT NOT NULL,
  public_data TEXT NOT NULL,
  creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  duration INTEGER DEFAULT 30)
EOT;

const entry_create = "INSERT INTO tokac_entries (token, private_data, public_data, duration) VALUES (?,?,?,?)";
const entry_by_token = 'SELECT id, token, private_data, public_data, creation_date, duration FROM tokac_entries WHERE token = ?';
const entry_remove_by_id = 'DELETE FROM tokac_entries WHERE id = ?';

}


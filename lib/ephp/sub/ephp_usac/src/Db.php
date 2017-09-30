<?php
namespace ephp\usac;

class Db extends \ephp\db\Db {

const create_user = <<<EOT
CREATE TABLE IF NOT EXISTS usac_users(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL,
  mail TEXT UNIQUE,
  session TEXT UNIQUE DEFAULT NULL,
  last_login DATETIME DEFAULT NULL,
  type INTEGER NOT NULL DEFAULT 0,
  status INTEGER NOT NULL DEFAULT 0)
EOT;

const user_create = "INSERT INTO usac_users (name, password, mail, type) VALUES (?,?,?,?)";
const user_by_name = 'SELECT id, name, password, status, mail, session, type FROM usac_users WHERE name = ?';
const user_by_mail = 'SELECT id, name, password, status, mail, type FROM usac_users WHERE mail = ?';
const user_by_name_mail = 'SELECT id, name, password, status, mail, type FROM usac_users WHERE name = ? OR mail = ?';
const user_by_session = 'SELECT id, name, session, status, type FROM usac_users WHERE session = ?';
const user_change_password_by_name = "UPDATE usac_users SET password = ? WHERE name = ?";
const user_change_mail_by_name = "UPDATE usac_users SET mail = ? WHERE name = ?";

const session_new = "UPDATE usac_users SET session = ?, last_login = datetime('now') WHERE id =?";
const session_logout = 'UPDATE usac_users SET session = NULL WHERE session = ?';

}



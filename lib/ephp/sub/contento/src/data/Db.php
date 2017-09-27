<?php
namespace contento\data;

class Db extends \ephp\db\Db {

const create_data = <<<EOF
CREATE TABLE IF NOT EXISTS contento_data(
  name TEXT NOT NULL,
  collection TEXT NOT NULL,
  creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  data TEXT NOT NULL,
  PRIMARY KEY(name, collection))
EOF;

const create_collections = <<<EOF
CREATE TABLE IF NOT EXISTS contento_collections(
  name TEXT NOT NULL,
  data TEXT NOT NULL,
  PRIMARY KEY(name))
EOF;


const data_add = 'INSERT INTO contento_data(name, collection, data) VALUES(?,?,?)';
const data_update = 'UPDATE contento_data SET name = ?, data = ? WHERE name = ? AND collection = ?';
const data_delete = 'DELETE FROM contento_data  WHERE name = ? AND collection = ?';

const data_by_name_collection = 'SELECT name, creation, data FROM contento_data WHERE name = ? AND collection = ?';
const data_by_collection = 'SELECT name, creation, data FROM contento_data WHERE collection = ?';

const collection_add = 'INSERT INTO contento_collections(name, data) VALUES (?,?)';
const collection_delete_by = 'DELETE FROM contento_collections';

const collection_by = 'SELECT name, data FROM contento_collections';
const collection_by_name = 'SELECT name, data FROM contento_collections WHERE name = ?';

const data_count_by_name_collection = 'SELECT count(*) as number FROM contento_data WHERE name = ? AND collection = ?';

function for_each($name, ...$args) {
  foreach ( parent::for_each($name, ...$args) as $r ) {
    if ( isset($r['data']) ) $r['data'] = json_decode($r['data'], true);
    yield $r;
  }
}

function get($name, ...$args) {
  $r = parent::get($name, ...$args);
  if ( $r ) {
    if ( isset($r['data']) ) $r['data'] = json_decode($r['data'], true);
  }
  return $r; 
}

}



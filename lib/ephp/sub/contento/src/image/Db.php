<?php
namespace contento\image;

class Db extends \ephp\db\Db {

const create_image = <<<EOF
CREATE TABLE IF NOT EXISTS contento_image(
  id TEXT PRIMARY KEY,
  time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  path TEXT NOT NULL,
  description TEXT DEFAULT NULL,
  thumbnail BLOB NOT NULL,
  sizes TEXT NOT NULL DEFAULT '{}')
EOF;

const image_add = 'INSERT INTO contento_image(id, path, description, sizes, thumbnail) VALUES(?,?,?,?,?)';
const image_by_id = 'SELECT id, time, path, sizes, description, thumbnail FROM contento_image WHERE id = ?';
const image_update_by_id = "UPDATE contento_image SET time = datetime('now'), sizes = ?, description = ? WHERE id = ?";
const image_update_file_by_id = "UPDATE contento_image SET time = datetime('now'), path = ?, thumbnail = ?, sizes = ?, description = ? WHERE id = ?";
const image_by = 'SELECT id, time, path, sizes, description, thumbnail FROM contento_image';
const image_info_by = 'SELECT id, time, path, sizes FROM contento_image';

function for_each($name, ...$args) {
  foreach ( parent::for_each($name, ...$args) as $r ) {
    if ( isset($r['sizes']) ) $r['sizes'] = json_decode($r['sizes'], true);
    yield $r;
  }
}

function get($name, ...$args) {
  $r = parent::get($name, ...$args);
  if ( $r ) {
    if ( isset($r['sizes']) ) $r['sizes'] = json_decode($r['sizes'], true);
  }
  return $r; 
}

}



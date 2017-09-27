<?php
namespace contento\image;

class Model {

public $db;
public $file_dir;

function dir_current_year() {

  $folder = [
    'year' => date('Y'),
    'base' => $this->file_dir . DIRECTORY_SEPARATOR . 'images'
  ];

  $folder['full'] = $folder['base'] . DIRECTORY_SEPARATOR . $folder['year'];

  @mkdir($folder['full'], 0777, true);

  return $folder;
}

function image_add($file, $description, $sizes) {
  $id = uniqid();
  $thumbnail = self::get_thumbnail($file['tmp_name']);

  $filename = self::image_normalize_filename($file, $id);

  $folder = $this->dir_current_year();

  $this->db->call('image_add', $id, $folder['year'] . DIRECTORY_SEPARATOR . $filename, $description, json_encode($sizes), $thumbnail);

  copy($file['tmp_name'], $folder['full'] . DIRECTORY_SEPARATOR . $filename);

  return ['id' => $id ];
}

function image_update_by_id($id, $description, $sizes) {
  $this->db->call('image_update_by_id', json_encode($sizes), $description, $id);
  return ['id' => $id];
}

function image_update_file_by_id($id, $file, $description, $sizes) {
  $thumbnail = self::get_thumbnail($file['tmp_name']);

  $filename = self::image_normalize_filename($file, $id);
   
  $folder = $this->dir_current_year();

  $this->db->call('image_update_file_by_id', $folder['year'] . DIRECTORY_SEPARATOR . $filename, $thumbnail, json_encode($sizes), $description, $id);

  copy($file['tmp_name'], $folder['full'] . DIRECTORY_SEPARATOR . $filename);

  return ['id' => $id];
}

function absolute_path($path) {
  return $this->file_dir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $path;
}

function image_by_id($id) {
  if ( $r = $this->db->get('image_by_id', $id) ) {
    $r['filename'] = $this->absolute_path($r['path']);
    return $r;
  } else Error::fire('IMAGE_NOT_EXISTS');
}

function image_info_by() {
  $r = [];
  foreach ( $this->db->for_each('image_info_by') as $data ) {
    $data['filename'] = $this->absolute_path($data['path']);
    $r[] = $data;
  }
  return $r;
}

function image_by() {
  return iterator_to_array($this->db->for_each('image_by'));
}

static function get_thumbnail($file) {
  if ( !file_exists($file) ) Error::fire('IMAGE_DOES_NOT_EXIST');
  $command = sprintf("convert '%s' -type Grayscale -resize 100x100 -strip -gaussian-blur 0.05 -quality 40 -", $file);
  $handle = popen($command, 'r');
  $string = stream_get_contents($handle);
  pclose($handle);
  return base64_encode($string);
}

static function image_normalize_filename($file, $salt = '') {
  $extension = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/gif' => 'gif'][$file['type']] ?? Error::fire('IMAGE_DOES_NOT_EXIST'); 
  return $salt  . '.' . $extension;
}

}





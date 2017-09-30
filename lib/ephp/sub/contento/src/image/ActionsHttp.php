<?php
namespace contento\image;

class ActionsHttp {

public $image_model;

function image_file_by_id($session, $id) {
  $data = $this->image_model->image_by_id($id);
  return [
    'filename' => $data['filename'],
    '__response_type' => 'file'
  ];
}

function image_by_id($session, $id) {
  $data = $this->image_model->image_by_id($id);
  unset($data['filename']);
  unset($data['path']);
  return $data;
}

function image_add($session, $file, $description, $sizes) {
  if ( ($file['error'] ?? 0) == 1 ) \ephp\mvc\Error::fire('FILE_SIZE_EXCEEDED'); 
  return $this->image_model->image_add($file, $description, $sizes);
}

function image_by($session) {
  return $this->image_model->image_by();
}

function image_update_file_by_id($session, $id, $file, $description, $sizes) {
  return $this->image_model->image_update_file_by_id($id, $file, $description, $sizes);
}

function image_update_by_id($session, $id, $description, $sizes) {
  return $this->image_model->image_update_by_id($id, $description, $sizes);
}

}



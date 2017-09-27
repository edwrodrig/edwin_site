<?php
namespace contento\data;

class ActionsHttp {

public $data_model;

function contento_data_add($session, $data, string $collection) {
  return $this->data_model->data_add($data, $collection);
}

function contento_data_update($session, $data, string $name, string $collection) {
  return $this->data_model->data_update($data, $name, $collection);
}

function contento_data_delete($session, string $name, string $collection) {
  return $this->data_model->data_delete($name, $collection);
}

function contento_data_by_name_collection($session, string $name, string $collection, bool $short = false) {
  return $this->data_model->data_by_name_collection($name, $collection, $short);
}

function contento_data_by_collection($session, string $collection, bool $short = true ) {
  return $this->data_model->data_by_collection($collection, $short);
}

function contento_collection_by($session) {
  return $this->data_model->collection_by();
}

function contento_collection_by_name($session, string $name) {
  return $this->data_model->collection_by_name($name);
}

}



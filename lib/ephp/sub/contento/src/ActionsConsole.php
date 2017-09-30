<?php
namespace contento;

/**
 * CONTENTO v0.1
 * Content Manager
 * by Edwin Rodríguez
 */
class ActionsConsole {

public $data_model;
public $default_types_folder;

/**
 * @desc Import collection information
 * @param dir Directory with collection information
 */
function contento_collection_set($dir = null) {
  if ( !empty($this->default_types_folder) )
    $dir = $this->default_types_folder;

  if ( !is_dir($dir) ) { echo "[$dir] is not a directory\n"; return; }

  $builder = new CollectionBuilder;
  
  foreach ( new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir)) as $file ) {
    if ( preg_match("/.json$/", $file) ) {
      echo "Reading file[$file]\n";
      $file_data = json_decode(file_get_contents($file), true);
      if ( is_null($file_data) ) {
        echo "File [$file] has a wrong format\n";
        return;
      }
      $builder->add($file_data);
    }
  }

  $this->data_model->collection_delete_by();
  foreach ( $builder->collections as $collection ) {
    $name = $collection['name'];
    echo "Adding collection [$name]\n";
    $this->data_model->collection_add($builder->resolve_type($collection));
  }
}

/**
 * @desc Import data from json
 * @param filename Filename of the json array
 * @param collection Collection name to insert
 */
function contento_data_import(string $filename, string $collection) {
  $data = json_decode(file_get_contents($filename), true);
  foreach ( $data as $d ) {
    $this->data_model->data_add(json_encode($d), $collection);
  }
}

/**
 * @desc Generate collection from type
 * @param  input type json filename
 */
function contento_collection_from_type(string $input) {
  $type = json_decode(file_get_contents($input), true);

  echo json_encode(
    [ 'name' => $type['name'] ?? '' . 's',
      'type' => 'collection',
      'label' => $type['label'] ?? [],
      'elem' => [
        'type' => 'custom',
        'type_name' => $type['name'] ?? ''
      ]
    ], JSON_PRETTY_PRINT);
}

/**
 * @desc Delete data from collection
 * @param name The identification name of the data
 * @param collection Collection name of the data
 */   
function contento_data_delete(string $name, string $collection) {
  $this->data_model->data_delete($name, $collection);
}

function contento_collection_check(string $collection) {
  try {
    $this->data_model->collection_check($collection);
  } catch ( \Exception $e ) {
    if ( isset($e->contento_data) ) {
      printf("Error: %s\n", $e->getMessage());
      file_put_contents('wrong_data.json', json_encode($e->contento_data, JSON_PRETTY_PRINT));
      echo "Wrong data dumped in file [wrong_data.json]\n";
      echo "vim wrong_data.json;\n";
      printf("php contento.php contento_data_update wrong_data.json %s;\n", $collection);
    }
  }
}

function contento_data_raw_by_name_collection(string $name, string $collection) {
  echo json_encode($this->data_model->data_raw_by_name_collection($name, $collection), JSON_PRETTY_PRINT);
}

function contento_data_update(string $filename, string $collection) {
  $data = json_decode(file_get_contents($filename), true);
  if ( is_null($data) ) throw new \Exception('INVALID_JSON');
  $this->data_model->data_update($data, $data['id'], $collection);
}

}


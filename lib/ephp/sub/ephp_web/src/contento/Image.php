<?php

namespace ephp\web\contento;

class Image {

static $required_images = [];

static function href($id, $options = []) {
  if ( empty($id) ) return "";
  
  $data = [
    'id' => $id
  ];

  $name_parts = [ $id ];


  if ( isset($options['type']) ) {
    $data['type'] = $options['type'];
    $name_parts[] = $options['type'];
  }

  $dim = ['w' => '', 'h' => ''];

  if ( isset($options['w']) ) {
    $dim['w'] = $options['w'];
  }
  
  if ( isset($options['h']) ) {
    $dim['h'] = $options['h'];
  }

  $dim_str = implode('x', $dim);
  if ( $dim_str != 'x' )
    $name_parts[] = $dim_str;

  $data['filename'] = implode('_', $name_parts);
  $data['dim'] = $dim;
  $data['ext'] = $options['ext'] ?? 'jpg';

  $data['filename'] .= '.' . $data['ext'];

  self::$required_images[$data['filename']] = $data;

  return '/contento_images/' . $data['filename'];
}

static function cache_images($images, $clean_cache = false) {
  $cache_file = \ephp\web\Context::cache('images_cache.json', true);
  $cache = [];
  if ( file_exists($cache_file) ) {
    $cache = json_decode(file_get_contents($cache_file), true) ?? [];
  }

  foreach ( self::$required_images as $id => $image ) {
    try {
      $data = $images[$image['id']];
      if ( !isset($cache[$image['filename']]) || $cache[$image['filename']]['time'] < $data['time'] ) {

        $output = \ephp\web\Context::cache('images' . DIRECTORY_SEPARATOR . $image['filename'], true);
        printf("Processing image[%s]\n", $image['filename']);
        if ( $image['ext'] == 'png' ) 
          \ephp\Image::optimize_png($data['filename'], $output, $image['dim']);
        else if ( $image['ext'] == 'jpg' ) 
          \ephp\Image::optimize_jpg($data['filename'], $output, $image['dim']);
        $cache[$image['filename']] = [ 'filename' => $output, 'time' => $data['time'] ];
      }
      
    } catch ( \Exception $e ) {
      var_dump($e);
    }
  }

  if ( $clean_cache ) {
    foreach ( $cache as $id => $data ) {
      if ( isset(self::$required_images[$id]) ) continue;
      printf("Image not longer used[%s]", $data['filename']);
      unlink($data['filename']);
      echo "...DONE\n";
      unset($cache[$id]);
    }
  }

  symlink(\ephp\web\Context::cache('images'), \ephp\web\Context::output('contento_images'));
  file_put_contents($cache_file, json_encode($cache, JSON_PRETTY_PRINT));
}

}

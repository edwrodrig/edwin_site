<?php

namespace ephp\web\contento;

class Image {

static $required_images = [];

static function href($id, $options = []) {
  if ( empty($id) ) return "";
  
  $data = [
    'id' => $id
  ];

  if ( isset($options['type']) ) {
    $data['type'] = $options['type'];
  }

  if ( isset($options['w']) ) {
    $data['w'] = $options['w'];
    $data['h'] = $options['h'] ?? '';
  }

  if ( isset($options['type']) ) {
    $data['type'] = $options['type'];
  }

  $data['filename'] = implode('_', $data);
  
  $data['ext'] = $options['ext'] ?? 'jpg';

  $data['filename'] .= '.' . $data['ext'];

  self::$required_images[$data['filename']] = $data;

  return '/contento_images/' . $data['filename'];
}

static function cache_images($images) {
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
        $data = $images[$image['id']];
        printf("Processing image[%s]\n", $image['filename']);
        if ( !isset($image['w']) ) {
          passthru(sprintf("cp %s %s", $data['filename'], $output));
        } else {
          if ( isset($image['h']) && !empty($image['h']) ) {
            $size = $image['w'] . 'x' . $image['h'] ?? '';
            passthru(sprintf("convert %s -resize %s^ -gravity center -quality 75 -extent %s %s", $data['filename'], $size, $size, $output));
          } else {
            $size = $image['w'];
            passthru(sprintf('convert %s -resize %s\> -quality 75 %s', $data['filename'], $size, $output));
          }
        }
        $cache[$image['filename']] = [ 'filename' => $output, 'time' => $data['time'] ];
      }
//      passthru(sprintf("cp %s %s", $cache[$image['filename']]['filename'], \ephp\web\Context::output('contento_images/' . $image['filename'], true)));
    } catch ( \Exception $e ) {
      var_dump($e);
    }
  }
  symlink(\ephp\web\Context::cache('images'), \ephp\web\Context::output('contento_images'));
  file_put_contents($cache_file, json_encode($cache, JSON_PRETTY_PRINT));
}

}

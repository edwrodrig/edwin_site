<?php

namespace edwin\web;

class Builder {

function make() {
  \data()['projects'] = json_decode(file_get_contents(__DIR__ . '/../../data/files/projects.json'), true);
  TemplatePage::$base_metadata = json_decode(file_get_contents(__DIR__ . '/../../data/files/base_metadata.json'), true);
  TemplatePage::$style = json_decode(file_get_contents(__DIR__ . '/../../data/files/template_style.json'), true);

  $posts = [];

  foreach ( new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../../data/files/posts')) as $file ) {
    if ( !$file->isFile() ) continue;
    $data = file_get_contents($file->getPathName());
    $data = explode("\n---\n", $data);
    $json = json_decode($data[0], true);
    $json["content"] = $data[1];
    $json['id'] = $file->getBasename('.' . $file->getExtension());
    $posts[] = $json;
  }

  \data()['posts'] = $posts;
  \data()['posts']->rsort();

  $this->build('es');

}

function build($lang) {
  $b = new \ephp\web\Builder;
  $b->input_dir = __DIR__ . '/../files';
  $b->output_dir = __DIR__ . '/../../../../output/site/' . $lang;
  $b->cache_dir = __DIR__ . '/../../../../cache/site';

  $b->lang = $lang;

  $b('.');

  \ephp\web\contento\Image::cache_images(\data()['images']);
  $b->finalize();
}

}

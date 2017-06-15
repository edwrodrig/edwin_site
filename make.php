<?php
require_once(__DIR__ . '/include.php');

$b = new \ephp\web\Builder;

$b->input_dir = 'files';
$b->output_dir = 'output';
$b->lang = 'es';

\Data::setProject(tr(json_decode(file_get_contents('data/projects.json'), true)));
MyTemplatePage::$base_metadata = tr(json_decode(file_get_contents('data/base_metadata.json'), true));
MyTemplatePage::$style = json_decode(file_get_contents('data/template_style.json'), true);

$posts = [];

foreach ( new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('data/posts')) as $file ) {
  if ( !$file->isFile() ) continue;
  $data = file_get_contents($file->getPathName());
  $data = explode("\n---\n", $data);
  $json = json_decode($data[0], true);
  $json["content"] = $data[1];
  $json['id'] = $file->getBasename('.' . $file->getExtension());
  $posts[] = $json;
}

\Data::setPost($posts);

$b('.');


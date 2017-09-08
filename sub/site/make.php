<?php
require_once(__DIR__ . '/include.php');

\data('edwin')['projects'] = json_decode(file_get_contents(__DIR__ . '/../data/files/projects.json'), true);
MyTemplatePage::$base_metadata = json_decode(file_get_contents(__DIR__ . '/../data/files/base_metadata.json'), true);
MyTemplatePage::$style = json_decode(file_get_contents(__DIR__ . '/../data/files/template_style.json'), true);

$posts = [];

foreach ( new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../data/files/posts')) as $file ) {
  if ( !$file->isFile() ) continue;
  $data = file_get_contents($file->getPathName());
  $data = explode("\n---\n", $data);
  $json = json_decode($data[0], true);
  $json["content"] = $data[1];
  $json['id'] = $file->getBasename('.' . $file->getExtension());
  $posts[] = $json;
}

\data('edwin')['posts'] = $posts;
\data('edwin')['posts']->sort();

//$b('.');


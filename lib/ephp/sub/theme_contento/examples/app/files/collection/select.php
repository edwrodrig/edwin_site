<?php

global $collections;

foreach ( $collections as $collection ) {

ephp\web\Builder::page_process(
  '/collection/' . $collection['name'] . '/select.html',
  function() use($collection) {
    \theme\contento\TemplateCollectionSelect::create($collection)->print();
  }
);

}


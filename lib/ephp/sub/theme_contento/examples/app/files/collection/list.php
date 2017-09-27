<?php

global $collections;

foreach ( $collections as $collection ) {
ephp\web\Builder::page_process(
  '/collection/' . $collection['name'] . '/list.html',
  function() use($collection) {
    \theme\contento\TemplateCollection::create($collection)->print();
  }
);

}


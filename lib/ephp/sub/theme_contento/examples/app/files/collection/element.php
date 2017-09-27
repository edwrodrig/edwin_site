<?php

global $collections;

foreach ( $collections as $collection ) {
 ob_start();
 var_dump($collection);
  error_log(ob_get_clean());
 $name = $collection['name'];
 $collection = $collection['data'];
ephp\web\Builder::page_process(
  '/collection/' . $name . '/element.html',
  function() use($collection) {
    \theme\contento\TemplateElement::create($collection)->print();
  }
);

}


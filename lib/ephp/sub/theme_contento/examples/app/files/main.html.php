<?php

(new class extends \theme\contento\TemplatePage {

function __construct() {
  parent::__construct();
}

function body($content = '') {
  global $collections;
  foreach ( $collections as $collection ) {
    t__($this->button_primary, 'a', ['href' => '/collection/' . $collection['name'] .'/list.html', 'style' => ['width' => '200px', 'height' => '200px']]);
      tag()(tr($collection['label']));
    __t();
  }

  t__($this->button_primary, 'a', ['href' => '/collection/image/list.html' , 'style' => ['width' => '200px', 'height' => '200px']]);
    tag()(tr(['es' => 'Imágenes', 'en' => 'Images']));
  __t();
  
}

})->print();

<?php

namespace theme\app;

class TemplatePageWithLoading extends TemplatePageStacked {

function __construct() {
  parent::__construct();
  $this->body->set(['style' => ['background-color' => 'white']]);
}

function section_wait() {
  $this->fragment_page_wait(tr(['es' => 'Cargando...', 'en' => 'Loading...']));
}

function section_error() {
  $this->fragment_page(
    'warning',
    tr(['es' => 'Ha ocurrido un error', 'en' => 'An error has occurred']),
    function() {
      tag('#placeholder_error_message', 'p')();
    }
  );
}

function body($content = '') {
  t__(['name' => 'first']);
    $this->section_wait();
  __t();
  t__(['name' => 'main']);
    echo $content;
  __t();
  t__(['name' => 'error']);
    $this->section_error();
  __t();
}

}

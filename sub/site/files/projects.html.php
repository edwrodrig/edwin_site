<?php

(new class extends \edwin\web\TemplatePage {

function __construct() {
  $metadata = ['page' => ['title' => tr(['es' => 'Proyectos', 'en' => 'Projects'])]];
  parent::__construct($metadata);
}


function body($content = '') {
  t__(['class' => 'section-container']);
  t__(['class' => 'container-padding']);
    t__(['class' => ['bigger-font']]);
    tag('h1')(tr(['en' => 'Projects', 'es' => 'Proyectos']));
    __t();
    tag('hr')();
    t__(['class' => ['layout-column', 'grid-padding']]);
    foreach ( \data()['projects'] as $pro ) {
      t__();
        $this->fragment_project_box($pro);
      __t();
    }
    __t();
  __t();
  __t();
}

})->print();

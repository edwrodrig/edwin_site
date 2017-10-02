<?php

(new class extends \edwin\web\TemplatePage {

function __construct() {
  $metadata = ['page' => ['title' => tr(['es' => 'Artículos', 'en' => 'Posts'])]];
  parent::__construct($metadata);
}


function body($content = '') {
  t__(['class' => 'section-container']);
  t__(['class' => 'container-padding']);
    t__(['class' => 'bigger-font']);
    tag('h1')(tr(['es' => 'Artículos', 'en' => 'Articles']));
    __t();
    tag('hr')();
    t__(['class' => ['layout-column', 'grid-padding']]);
    foreach ( \data()['posts'] as $pro ) {
      t__();
        $this->fragment_post_box($pro);
      __t();
    }
    __t();
  __t();
  __t();
}

})->print();

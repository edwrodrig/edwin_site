<?php

(new class extends MyTemplatePage {

function __construct() {
  $metadata = ['page' => ['title' => tr(['es' => 'Proyectos', 'en' => 'Projects'])]];
  parent::__construct($metadata);
}


function main($content = '') {
  container__()([$this->style_container_padding]);
    tag($this->title)(tr(['en' => 'Projects', 'es' => 'Proyectos']));
    tag($this->separator)();
    foreach ( \Data::forProject() as $pro ) {
      (new \blog\web\ProjectBox)($pro);
    }
  __container();
}

})();

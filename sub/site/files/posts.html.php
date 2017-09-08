<?php

(new class extends MyTemplatePage {

function __construct() {
  $metadata = ['page' => ['title' => tr(['es' => 'Artículos', 'en' => 'Posts'])]];
  parent::__construct($metadata);
}


function main($content = '') {
  container__()([$this->style_container_padding]);
    tag($this->title)(tr(['en' => 'Artículos']));
    tag($this->separator)();
    foreach ( \Data::forPost() as $pro ) {
      (new \blog\web\PostBox)($pro);
    }
  __container();
}

})();

<?php

namespace theme\contento;

class TemplatePage extends \theme\app\TemplatePage {

function __construct($metadata = []) {
  parent::__construct($metadata);
  $this->body->set([
    'style' => [
      '@media ( min-height : 600px )' => [
        'box-sizing' => 'border-box',
        'height' => '100vh'
      ]
    ]
  ]);
}

function head() {
  parent::head();
  \ephp\web\Fa::html_include();
}

function header($content = '') {
  echo $content;
}


function body($content = '') {
  t__(['class' => ['layout-column', ['width' => '100%', 'height' => '100%']]]);
    t__(['class' => ['title-block']]);
       $this->bottom_up_call('header');
    __t();
    t__(['style' => ['flex-grow' => 1]]);
      echo $content;
    __t();
  __t();
}

}

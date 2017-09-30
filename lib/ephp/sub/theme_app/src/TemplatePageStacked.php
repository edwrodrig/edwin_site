<?php

namespace theme\app;

class TemplatePageStacked extends \ephp\web\TemplatePageStacked {

use TemplateCommon;

function __construct() {
  parent::__construct();
  $this->body->set(['background-color' => 'rgba(0,0,0,0.5)']);
}

function head() {
  parent::head();
  $this->styles();
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_parent();
}

}

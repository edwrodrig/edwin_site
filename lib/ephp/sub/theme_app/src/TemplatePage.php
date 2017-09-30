<?php

namespace theme\app;

class TemplatePage extends \ephp\web\TemplatePage {

use TemplateCommon;

function __construct($metadata = []) {
  parent::__construct($metadata);
  $this->body->set(['style' => ['background-color' => self::$style['background_color']]]);
}

function head() {
  parent::head();
  $this->styles();
}

}

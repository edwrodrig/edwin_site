<?php

namespace theme\app;

class TemplatePage extends \ephp\web\TemplatePage {

use TemplateCommon;

static public $base_metadata = [];

function __construct($metadata = []) {
  parent::__construct(array_replace_recursive(self::$base_metadata, $metadata));
  $this->body->set(['style' => ['background-color' => self::$style['background_color']]]);
}

function head() {
  parent::head();
  $this->styles();
}

}

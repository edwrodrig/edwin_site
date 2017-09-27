<?php

namespace theme\usac;

class TemplatePageTokac extends \theme\tokac\TemplatePage {

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
}

}

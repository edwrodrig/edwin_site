<?php

namespace theme\usac;

class TemplatePage extends \theme\app\TemplatePage {

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
}

}

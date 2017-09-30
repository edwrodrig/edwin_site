<?php

class TemplateModal extends \ephp\web\TemplateOverlay {

function body($content) {
?>
  <div>HOla</div>
  <button type="button" onclick="slot_close()">Close</button>
<?php
}

}

(new class extends \ephp\web\TemplatePage {

function __construct() {
  parent::__construct();
}

function body($content = '') {
  tag('button', ['type' => 'button', 'onclick' => TemplateModal::launch_in_iframe()])("Submit");
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_parent();
}

})->print();

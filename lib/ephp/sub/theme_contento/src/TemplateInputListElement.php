<?php

namespace theme\contento;

class TemplateInputListElement extends TemplateMainWithTools {

public $input;

function __construct($elem) {
  parent::__construct();
  $this->input = \ephp\web\contento\Input::create($elem);
  $this->closable = true;
}

function head() {
  parent::head();
  \ephp\web\WidgetTableListJs::html_include();
  \ephp\web\contento\InputString::html_include();
  \ephp\web\contento\InputDate::html_include();
  \ephp\web\contento\InputDateTime::html_include();
  TemplateCommon::style_items();
}

function body($content = '') {
  t__('fieldset');
  ($this->input)();
  __t();
}

function section_buttons() {
  $this->button = $this->fragment_button(tr(['es' => 'Agregar', 'en' => 'Add']), ['class' => 'button-primary', 'type' => 'button', 'onclick' => 'do_action()'], '#');
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_child();
?>
<script>
function init() {;}

var mode = 'add';
var elem_data = null;

function check() {
  slot_change_page('first');
  if ( mode == 'add' ) {
    <?=js($this->input)?>.clear();
  } else if ( mode == 'edit' ) {
    <?=js($this->input)?>.set(elem_data);
  }

  slot_change_page('main');
}

function slot_set_mode_add() {
  mode = 'add';
  check();
}

function slot_set_mode_edit(data) {
  mode = 'edit';
  elem_data = data;
  <?=js($this->button)?>.innerHTML = "<?=tr(['es' => 'Guardar', 'en' => 'Save'])?>";
  check();
}

function do_action() {
  var data = <?=js($this->input)?>.get();
  console.log(data);
  IFRAME_MANAGER_CHILD.ret(data);
}
</script>
<?php
}

}

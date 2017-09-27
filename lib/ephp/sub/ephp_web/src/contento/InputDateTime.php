<?php

namespace ephp\web\contento;

class InputDateTime extends Input {

static function html_include() {
  if ( dg() ) :
  \ephp\web\ProcFile::register(__DIR__ . '/../../files', 'js/datetimepicker.min.js');
  \ephp\web\ProcFile::register(__DIR__ . '/../../files', 'css/datetimepicker.base.css');
?>
<link rel="stylesheet" href="/css/datetimepicker.base.css">
<script src='/js/datetimepicker.min.js'></script>
<?php
  endif;
}

function content() {
  $date = tag('input', '#', ['type' => 'text'])();
?>
<script>
(function() {
var field =  <?=js($date)?>;

field.picker = new DateTimePicker('#<?=js($date)->id()?>', {
  allowEmpty: true,
  timePicker : true,
  format: 'Y-m-d H:i',
  inputOutputFormat: 'Y-m-d H:i'
})
})();
</script>
<?php
}

function js_functions() {
if ( dg() ) :
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.datetime = function(node, type) {
  return {
    type : type,
    node : node,
    get : function() { return this.node.picker.getDate('Y-m-d H:i'); },
    set : function(value) { this.node.picker.setDate(value); },
    clear: function() { this.node.picker.setDate(); }
  };
};
</script>
<?php
endif;

}

}

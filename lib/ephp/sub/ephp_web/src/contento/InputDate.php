<?php

namespace ephp\web\contento;

class InputDate extends Input {

static function html_include() {
  InputDateTime::html_include();
}

function content() {
  $date = tag('input', '#', ['type' => 'text'])();
?>
<script>
(function() {
var field =  <?=js($date)?>;

field.picker = new DateTimePicker('#<?=js($date)->id()?>', {
  allowEmpty: true,
  format: 'Y-m-d',
  inputOutputFormat: 'Y-m-d'
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
    get : function() { return this.node.picker.getDate('Y-m-d'); },
    set : function(value) { this.node.picker.setDate(value); },
    clear: function() { this.node.picker.setDate(); }
  };
};
</script>
<?php
endif;

}

}

<?php

namespace ephp\web\contento;

class InputBool extends Input {

function content() {
  tag('input', ['type' => 'checkbox'])();
}

function js_functions() {
if ( dg() ) :
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.bool = function(node, type) {
  return  {
    type : type,
    node : node,
    get : function() { return this.node.checked; },
    set : function(value) { this.node.checked = value; },
    clear : function() { this.node.checked = false; }
  };
};
</script>
<?php
endif;
}

}


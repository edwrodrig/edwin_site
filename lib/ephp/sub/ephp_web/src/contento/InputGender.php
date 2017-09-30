<?php

namespace ephp\web\contento;

class InputGender extends Input {

function content() {
  t__();
  tag('input', ['type' => 'radio', 'name' => js($this->container)->id(), 'value' => 'm'])();
  t__('label');
    \ephp\web\Fa::inline('male');
    echo tr(['es' => 'Masculino', 'en' => 'Male']);
  __t();

  tag('input', ['type' => 'radio', 'name' => js($this->container)->id(), 'value' => 'f'])();
  t__('label');
    \ephp\web\Fa::inline('female');
    echo tr(['es' => 'Femenino', 'en' => 'Female']);
  __t();
  __t();
}

function js_functions() {
if ( dg() ) :
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.gender = function(node, type) {
  var nodes = node.getElementsByTagName('INPUT');

  return {
    type : type,
    node: nodes,
    get : function() {
      if ( this.node[0].checked ) return 'm';
      if ( this.node[1].checked ) return 'f';
      return null;
    },
    set : function(value) {
      if ( value == 'm' ) this.node[0].checked = true;
      else if ( value == 'f' ) this.node[1].checked = true;
      else this.clear();
    },
    clear : function() {
      this.node[0].checked = false;
      this.node[1].checked = false;
    }
  };
};
</script>
<?php

endif;
}

}

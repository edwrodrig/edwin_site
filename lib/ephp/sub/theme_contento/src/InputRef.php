<?php

namespace theme\contento;

class InputRef extends \ephp\web\contento\Input {

function content() {
  t__();
    tag()();
    tag('button', ['type' => 'button', 'onclick' => js($this)('dialog_new()')])(tr(['es' => 'Nuevo', 'en' => 'New']));
    tag('button', ['type' => 'button' , 'onclick' => js($this)('dialog_select()')])(tr(['es' => 'Elegir', 'en' => 'Choose']));
    tag('button', ['type' => 'button' , 'onclick' => js($this)('dialog_edit()')])(tr(['es' => 'Ver', 'en' => 'View']));
  __t();
}

function js_functions() {
if ( dg() ) :
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.ref = function(node, type) {
  node = node.children[0];
  return {
    type : type,
    node: node,
    get : function() {
      return this.node.innerHTML;
    },
    set : function(value) {
      this.node.innerHTML = value;
    },
    clear : function() {
      this.set('');
    },
    dialog_select : function() {
      var elem = this;
      IFRAME_MANAGER_PARENT.callback = function(value) { elem.set(value.id) };
      IFRAME_MANAGER_PARENT.open_url('/collection/' + type.collection + '/select.html');
    },
    dialog_new : function() {
      var elem = this;
      IFRAME_MANAGER_PARENT.callback = function(value) { elem.set(value.id) };
      IFRAME_MANAGER_PARENT.open_url('/collection/' + type.collection + '/element.html');
    },
    dialog_edit : function() {
      var elem = this;
      IFRAME_MANAGER_PARENT.callback = function(value) { elem.set(value.id) };
      IFRAME_MANAGER_PARENT.open_url('/collection/' + type.collection + '/element.html?' + elem.get());
    }
  };
};
</script>
<?php
endif;
}

}

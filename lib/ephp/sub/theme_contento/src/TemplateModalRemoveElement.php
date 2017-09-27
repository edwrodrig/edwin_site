<?php

namespace theme\contento;

class TemplateModalRemoveElement extends \theme\app\TemplatePageStacked {

public $collection;

function __construct($collection) {
  parent::__construct();
  $this->collection = $collection;
  $this->body->set(['style' => ['background-color' => 'rgba(0,0,0,0.5)']]);
}

function fragment_question() {
    $this->fragment_dialog('question', tr(['es' => 'Eliminar elemento', 'en' => 'Remove element']), function() {
    tag('p')(tr(['es' => '¿Estás seguro de querer eliminar el elemento?', 'en' => 'Are you sure to remove the element?']));
    t__(['class' => ['layout-row', 'layout-center', 'grid-padding']]);
      $this->fragment_button(tr(['es' => 'Si', 'en' => 'Yes']), ['onclick' => 'do_action()']);
      $this->fragment_button('No', ['onclick' => 'IFRAME_MANAGER_CHILD.close()', 'class' => ['button-primary']]);
    __t();
  });
}

function fragment_success() {
  $this->fragment_dialog('trash', tr(['es' => 'Elemento eliminado', 'en' => 'Element removed']), function() {
    $this->fragment_button('Ok', ['onclick' => 'IFRAME_MANAGER_CHILD.close()', 'class' => ['button-primary']]);
  });
}

function fragment_error() {
  $this->fragment_dialog('warning', tr(['es' => 'Error al eliminar', 'en' => 'Error at removing']), function() {
    tag('#placeholder_error_message', 'p')();
    $this->fragment_button(tr(['es' => 'Cerrar', 'en' => 'Close']), ['onclick' => 'IFRAME_MANAGER_CHILD.close()', 'class' => ['button-primary']]);
  });
}

function body($content = '') {
  t__(['name' => 'first']);
    $this->fragment_question();
  __t();
  t__(['name' => 'wait']);
    $this->fragment_dialog_wait(tr(['es' => 'Eliminando...', 'en' => 'Removing...']));
  __t();
  t__(['name' => 'success']);
    $this->fragment_success();
  __t();
  t__(['name' => 'error']);
    $this->fragment_error();
  __t();
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_child();
  (new \ephp\web\usac\Client)();
  (new \theme\contento\Client)();
?>
<script>
var index;
function slot_set_index(value) {
  index = value;
}

function do_action() {
  var config = {
    success: function(data) {
      IFRAME_MANAGER_CHILD.callback();
      slot_change_page('success');
    },
    error: function(data) {
      var message = '<?=tr(['es' => 'A ocurrido un error', 'en' => 'An error has ocurred'])?> : ' + data.message;
      slot_set_placeholder('placeholder_error_message', message);        
      slot_change_page('error');
    }
  };

  slot_change_page('wait');
  CONTENTO_CLIENT.remove_element(index, '<?=$this->collection['name']?>', config);

}
</script>
<?php
}

}

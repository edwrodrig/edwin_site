<?php

namespace theme\contento;

class TemplateElement extends TemplateMainWithTools {

public $collection;
public $input;
public $button;

function __construct($collection) {
  parent::__construct();
  $this->collection = $collection;
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
  $type = \contento\Type::create($this->collection['elem']);
  $this->input = \ephp\web\contento\Input::create($type);
  ($this->input)();
  echo $content;
}

function section_buttons() {
  $this->button = $this->fragment_button(tr(['es' => 'Agregar', 'en' => 'Add']), ['onclick' => 'do_action()', 'class' => 'button-primary'], '#');
  $this->fragment_button('Dump type', ['onclick' => 'debug_type()']);
  $this->fragment_button('Dump data', ['onclick' => 'debug_data()']);
}

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
  (new \theme\contento\Client)();
?>
<script>
function check() {
  elem_id = CONTENTO_CLIENT.get_token();
  if ( elem_id == '' ) {
    <?=js($this->input)?>.clear();
    slot_change_page('main');
  } else {
    slot_change_page('first');
    <?=js($this->button)?>.innerHTML = '<?=tr(['es' => 'Guardar', 'en' => 'Save'])?>';

    CONTENTO_CLIENT.get_element(
      elem_id,
      '<?=$this->collection['name']?>',
      {
        success: function(data) {
          <?=js($this->input)?>.set(data);
          slot_change_page('main');
        },
        error : function(data) {
          console.log(data);
          slot_set_placeholder('placeholder_error_message', data.message);
          slot_change_page('error');
        }
      }
    ); 
  }
}

function debug_type() {
  var win = <?=\ephp\web\Util::js_json_window($this->collection['elem'])?>; 
}

function debug_data() {
  var data = <?=js($this->input)?>.get();
  data = btoa(JSON.stringify(data));

  var win = window.open(
    "data:application/json;base64, " + data,
    "_blank",
    "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=780, height=200, top=" + (screen.height - 400) + ", left=" + (screen.width - 840)
  );
}

function do_action() {
  if ( elem_id == '') action_add();
  else action_edit();
}

function action_add() {
  <?=\theme\app\TemplateModalAction::launch_in_iframe(
    tr(['es' => 'Agregando...', 'en' => 'Adding...']),
    tr(['es' => 'Elemento agregado', 'en' => 'Element added'])
  );
  ?>;

  var data = <?=js($this->input)?>.get();
  CONTENTO_CLIENT.add_element(
    data,
    '<?=$this->collection['name']?>',
    {
      success: function(data) {
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
        IFRAME_MANAGER_CHILD.callback(data); 
      },
      error : function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message);
      }
    }
  );
}

function action_edit() {
  <?=\theme\app\TemplateModalAction::launch_in_iframe(
    tr(['es' => 'Guardando...', 'en' => 'Saving...']),
    tr(['es' => 'Elemento guardado', 'en' => 'Element saved'])
  );
  ?>;

  var data = <?=js($this->input)?>.get();

  CONTENTO_CLIENT.edit_element(
    elem_id,
    data,
    '<?=$this->collection['name']?>',
    {
      success: function(data) {
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
        IFRAME_MANAGER_CHILD.callback(data); 
      },
      error : function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message);
      }
    }
  );
}

var_elem_id = '';

</script>

<?php
}


}

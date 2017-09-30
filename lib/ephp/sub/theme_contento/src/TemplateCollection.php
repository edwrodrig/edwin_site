<?php

namespace theme\contento;

class TemplateCollection extends TemplateMainWithTools {

public $collection;
public $table;
public $search_input;

function __construct($collection) {
  parent::__construct();
  $this->collection = $collection;
  $this->table = new \ephp\web\WidgetTableListJs();
  $this->table->search_enabled = false;
  $this->table->table->set(['class' => 'contento-table']);
  $this->table->edit_event = 'IFRAME_MANAGER_PARENT.open_url("element.html?" + this.parentElement.parentElement.children[0].innerHTML)';
  $this->table->delete_event = 'remove_element(this)';
  $columns = [];

  $type = \contento\Type::create($collection['elem']);
  
  foreach ( $type->fields() as $name => $field ) {
    if ( !$field->displayable() ) continue;
    $element = [
      'name' => $name,
      'label' => tr($field->label()),
      'sort' => true
    ];

    if ( $name == 'id' ) {
      array_unshift($columns, $element); 
    } else {
      $columns[] = $element;
    }
  }

  $this->table->columns = $columns;
}

function head() {
  parent::head();
  \ephp\web\WidgetTableListJs::html_include();
  TemplateCommon::style_table();
}

function body($content = '') {
  ($this->table)();
}

function section_buttons() {
  $this->search_input = tag('input', '#', ['type' => 'text', 'placeholder' => tr(['es' => 'Buscar', 'en' => 'Find'])])();
  $this->fragment_button(tr(['es' => 'Agregar', 'en' => 'Add']), ['onclick' => 'IFRAME_MANAGER_PARENT.open_url("element.html")', 'class' => 'button-primary']);
  $this->fragment_button('Dump type', ['onclick' => 'debug_type()']);
  $this->fragment_button('Dump data', ['onclick' => 'debug_data()']);
}

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
  (new \theme\contento\Client)();
?>
<script>
function debug_type() {
  var win = <?=\ephp\web\Util::js_json_window($this->collection)?>;
}

function debug_data() {
  var data = <?=js($this->table)?>.data;
  data = btoa(JSON.stringify(data));

  var win = window.open(
    "data:application/json;base64, " + data,
    "_blank",
    "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=780, height=200, top=" + (screen.height - 400) + ", left=" + (screen.width - 840)
  );
}

function remove_element(elem) {
  <?=\theme\contento\TemplateModalRemoveElement::launch_in_iframe($this->collection)?>;
  IFRAME_MANAGER_PARENT.signal('slot_set_index', elem.parentElement.parentElement.children[0].innerHTML);
}

function check() {
  slot_change_page('first');
  CONTENTO_CLIENT.get_elements(
    '<?=$this->collection['name']?>',
    {
      success: function(data) {
        var table = <?=js($this->table)?>;
        table.data = data;
        table.list.clear();
        var to_add = [];
        for ( var i = 0 ; i < data.length ; i++ ) {
          var elem = data[i];
          for ( var prop  in elem ) {
            var field = elem[prop];
            if ( field instanceof Object ) {
              if ( field.hasOwnProperty('<?=\ephp\Format::$current_lang?>') )
                elem[prop] = field['<?=\ephp\Format::$current_lang?>'];
              else
                elem[prop] = '';
            }
          }
          to_add.push(elem);
        }
        table.list.add(to_add);
        table.list.search();
        <?=js($this->search_input)?>.value = '';
        slot_change_page('main');
      },
      error : function(data) {
        console.log(data);
        slot_set_placeholder('placeholder_error_message', data.message);
        slot_change_page('error');
      }
    });
}

IFRAME_MANAGER_PARENT.callback = check;
<?=js($this->search_input)?>.addEventListener('keyup', function() {
  var table = <?=js($this->table)?>;
  table.list.search(this.value);
});

</script>
<?php
}

}

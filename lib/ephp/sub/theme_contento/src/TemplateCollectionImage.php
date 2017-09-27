<?php

namespace theme\contento;

class TemplateCollectionImage extends TemplateMainWithTools {

public $table;
public $search_input;

function __construct() {
  parent::__construct();
  $this->table = new \ephp\web\WidgetTableListJs();
  $this->table->search_enabled = false;
  $this->table->table->set(['class' => 'contento-table']);
  $this->table->edit_event = 'IFRAME_MANAGER_PARENT.open_url("element.html?" + this.parentElement.parentElement.children[0].innerHTML)';
  //$this->table->delete_event = 'remove_element(this)';
  $columns = [
    [ 'name' => 'id', 'label' => 'id', 'sort' => true],
    [ 'name' => 'description', 'label' => tr(['es' => 'Descripción', 'en ' => 'Description']), 'sort' => true],
    [ 'name' => 'thumbnail', 'type' => 'image', 'label' => tr(['es' => 'Vista preeliminar', 'en' => 'Preview'])]
  ];

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
}

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
  (new \theme\contento\Client)();
?>
<script>
function init() { check(); }

function check() {
  slot_change_page('first');
  CONTENTO_CLIENT.get_images(
    {
      success: function(data) {
        var table = <?=js($this->table)?>;
        
        table.list.clear();
        var to_add = [];
        for ( var i = 0 ; i < data.length ; i++ ) {
          data[i].thumbnail = "data:image/jpg;base64," + data[i].thumbnail;
          to_add.push(data[i]);
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
  table.list.search(this.value, ['description', 'id']);
});
</script>
<?php
}


}

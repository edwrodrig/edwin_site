<?php

namespace ephp\web;

class WidgetTableListJs {

public $table;
public $columns;
public $search_enabled = null;
public $select_event = null;
public $edit_event = null;
public $delete_event = null;
public $move_event = null;

function __construct() {
  $this->table = tag('table', '#');
}

function __invoke() {
  $this->table->open();
    t__('thead');
      foreach ( $this->columns as $column ) {
        $modifiers = ['class' => [$column['name']]];
        if ( $column['hidden'] ?? false ) $modifiers['style'] = ['display' => 'none'];
        t__('th', $modifiers);
          echo $column['label'] ?? $column['name'];
          if ( $column['sort'] ?? false ) Fa::inline('sort' , ['class' => 'sort', 'data-sort' => $column['name']]);
        __t();
      }
      t__('th');
        if ( $this->search_enabled ) {
          tag('input', [
            'type' => 'text',
            'class' => ['search'],
            'placeholder' => tr(['es' => 'Buscar', 'en' => 'Find'])
          ])();
        }
      __t();
    __t();
    t__('tbody', ['class' => ['list']]);
    __t();
  $this->table->close();
  $this->js_functions();
}

function column_names() {
  $names = [];
  foreach ( $this->columns as $column ) {
    $names[] = $column['name'];
  }
  return $names;
}

function columns_for_list_js() {
  $names = [];
  foreach ( $this->columns as $column ) {
    if ( ($column['type'] ?? 'text') == 'image' ) {
      $names[] = [
        'name' => $column['name'],
        'attr' => 'src' 
      ];
    } else {
      $names[] = $column['name'];
    }
  }
  return $names;

}

function table_item() {
  ob_start();

  $modifiers = [];
  if ( !empty($this->move_event) ) {
    $modifiers = ['ondrop' => $this->move_event, 'ondragover' => "event.preventDefault()"];
  }

  t__('tr', $modifiers);
  foreach ( $this->columns as $column ) {
    $modifiers = ['class' => [$column['name']]];
    if ( $column['hidden'] ?? false ) $modifiers['style'] = ['display' => 'none'];

    $type = $column['type'] ?? 'text';

    if ( $type == 'image' ) {
      t__('td');
        tag('img', $modifiers)();
      __t();
    } else {
      tag('td', $modifiers)();
    }
    
  }
    t__('td');
      if ( !empty($this->select_event) ) {
        t__('button', ['type' => 'button', 'onclick' => $this->select_event]);
          Fa::icon('hand-pointer-o');
          tr(['es' => 'Seleccionar', 'en' => 'Select']);
        __t();
      }
      if ( !empty($this->edit_event) ) {
        t__('button', ['type' => 'button', 'onclick' => $this->edit_event]);
          Fa::icon('pencil');
          tr(['es' => 'Editar', 'en' => 'Edit']);
        __t();
      }
      if ( !empty($this->delete_event) ) {
        t__('button', ['type' => 'button', 'onclick' => $this->delete_event]);
          Fa::icon('trash');
          tr(['es' => 'Borrar', 'en' => 'Delete']);
        __t();
      }
      if ( !empty($this->move_event) ) {
        t__('span', ['draggable' => 'true', 'ondragstart' => 'event.dataTransfer.setData("text", this.parentElement.parentElement.rowIndex - 1)']);
          Fa::icon('arrows');
        __t();
      }
    __t();
  __t();
  return json_encode(ob_get_clean());

}

function html_id() {
  return $this->table->html_id();
}

static function html_include() {
  \ephp\web\ProcFile::register(__DIR__ . '/../files', 'js/list.min.js');
?>
<script src="/js/list.min.js"></script>
<?php
}

function js_functions() {
?>
<script>
(function() {
  var list = new List(
    '<?=js($this->table)->id()?>',
    {
      valueNames: <?=json_encode($this->columns_for_list_js())?> ,
      item: <?=$this->table_item()?>,
      indexAsync : true
    }
  );

  <?=js($this)?>.list = list;
})();
</script>
<?php
}

}

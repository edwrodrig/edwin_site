<?php

namespace ephp\web\contento;

class InputList extends Input {

public $elem;

const INTERNAL_ID = '__id';

function __construct($data) {
  parent::__construct($data);
  $this->elem = $this->data->elem();
}

function is_single_row() {
  return ! $this->elem instanceof \contento\TypeObject;
}

function content() {
  t__(['class' => ['contento-input-list']]);
  $list = new \ephp\web\WidgetTableListJs();
  $list->table->set(['class' => ['contento-table']]);

  $columns = [];
  $columns[] = [
    'name' => self::INTERNAL_ID,
    'label' => '',
    'hidden' => true
  ];


  if ( $this->is_single_row() ) {
    $columns[] = [
      'name' => 'value',
      'label' => tr(['es' => 'Valor', 'en' => 'Value'])
    ];

  } else {
    foreach ( $this->elem->fields() as $name => $field ) {
      if ( !$field->displayable() ) continue;
      $columns[] = [
        'name' => $name,
        'label' => tr($field->label())
      ];
      }
    }

  $list->columns = $columns;


  $list->edit_event =
      js($this)('dialog_edit(this)');

  $list->delete_event =
      js($this)('remove(this.parentElement.parentElement.rowIndex - 1)');

  $list->move_event =
      'event.preventDefault();'
    . js($this)('move(event.dataTransfer.getData("text"), this.rowIndex - 1);');

  $list();

  t__('button', [
      'type' => 'button',
      'onclick' => js($this)('dialog_add()')
     ]);
     \ephp\web\Fa::icon('plus-square');
     echo tr(['es' => 'Agregar', 'en' => 'Add']);
  __t();

  __t();
}


function js_script() {
  parent::js_script();
  if ( $this->elem->is_ref() ) {
?>
<script>
(function(){
  var elem = <?=js($this)?>;
  elem.node.dialog = function(data) {
    IFRAME_MANAGER_PARENT.open_url('/collection/<?=$this->elem->collection()?>/select.html');
  };

})();
</script>
<?php
  } else {
?>
<script>
(function(){
  var elem = <?=js($this)?>;
  elem.node.dialog = function (data) {
    <?=\theme\contento\TemplateInputListElement::launch_in_iframe($this->elem)?>;
    if ( data === undefined ) {
      IFRAME_MANAGER_PARENT.signal('slot_set_mode_add');
    } else {
      IFRAME_MANAGER_PARENT.signal('slot_set_mode_edit', data);
    }
  };
})();
</script>
<?php  
  }

}

function js_functions() {
if ( dg() ) :
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.list = function(node, type) {
  node = node.children[0];
  if ( !node.hasOwnProperty('elements') ) node.elements = [];
  return {
    type : type,
    node : node,
    update_list : function() {
      this.node.list.clear();
      for ( var i = 0 ; i < this.node.elements.length ; i++ ) {
        var elem;
        if ( type['elem']['type'] == 'object' ) {
          elem = JSON.parse(JSON.stringify(this.node.elements[i]));
        } else {
          elem = { value : this.node.elements[i]};
        }
        for ( var prop in elem ) {
          var field = elem[prop];
          if ( field instanceof Object ) {
            if ( field.hasOwnProperty('<?=\ephp\Format::$current_lang?>') )
              elem[prop] = field['<?=\ephp\Format::$current_lang?>'];
            else
              elem[prop] = '';
          } 
        }
        elem['<?=self::INTERNAL_ID?>'] = i;
        this.node.list.add(elem);
      }
    },
    dialog_add: function() {
      var list = this;
      IFRAME_MANAGER_PARENT.callback = function(value) {
        list.add(value);
      };
      this.node.dialog();
    },
    dialog_edit : function(elem) {
      var index = elem.parentElement.parentElement.rowIndex - 1;
      var list = this;
      IFRAME_MANAGER_PARENT.callback = function(value) {
        list.edit(index, value);
      }
      this.node.dialog(this.node.elements[index]);
    },
    get : function() {
      return this.node.elements;
    },
    set : function(value) {
      this.node.elements = value;
      this.update_list();
    },
    prepare_value : function(value) {
      if ( this.type['elem']['type'] == 'ref' || this.type['elem']['type'] == 'image_ref' )
        return value['id'];
      else
        return value;
    },
    add : function(value) {
      this.node.elements.push(this.prepare_value(value));
      this.update_list();
    },
    move : function(index_from, index_to) {
      if ( index_from == index_to ) return;

      var moving_element = this.node.elements[index_from];
      this.node.elements.splice(index_from, 1);
      this.node.elements.splice(index_to, 0, moving_element);

      this.update_list();

    },
    edit : function(index, value) {
      if ( index >= this.node.elements.length ) return;
      this.node.elements[index] = this.prepare_value(value);
      this.update_list();
    },
    remove : function(index) {
      if ( index >= this.node.elements.length ) return;
      this.node.elements.splice(index, 1);
      this.update_list();
    },
    clear : function() {
      this.node.elements = [];
      this.update_list();
    }
  };
};

</script>
<?php
endif;

}



}

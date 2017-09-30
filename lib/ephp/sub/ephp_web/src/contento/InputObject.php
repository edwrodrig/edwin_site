<?php

namespace ephp\web\contento;

class InputObject extends Input {

function content() {
  t__('fieldset', ['class' => ['contento-input-object']]);
  foreach ( $this->data->fields() as $name => $field ) {
    Input::create($field)();
  }
  __t();
}

function js_functions() {
if ( dg() ) :
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.object = function(node, type) {
  return {
    type : type,
    node : node,
    fields : function() {
      var result = [];
      var nodes = this.node.children;
      for ( var i = 0 ; i < nodes.length ; i ++ ) {
        var elem = CONTENTO_UI.get_element(nodes[i]);
        if ( elem == null ) continue;
        result.push(elem);
      }
      return result;
    },
    get : function() {
      var nodes = this.fields();
      var data = {};
      for ( var i = 0 ; i < nodes.length ; i ++ ) {
        var elem = nodes[i];
        data[elem.type.field] = elem.get();
      }
      return data;
    },
    set : function(value) {
      var nodes = this.fields();
      for ( var i = 0 ; i < nodes.length ; i++ ) {
        var elem = nodes[i];
        if ( value.hasOwnProperty(elem.type.field) ) {
          elem.set(value[elem.type.field]);
        }
      }
    },
    clear : function() {
      var nodes = this.fields();
      for ( var i = 0 ; i < nodes.length ; i++ ) {
        var elem = nodes[i];
        elem.clear();
      }
    }
  };
};
</script>
<?php
endif;

}


}
/*
function(data) {
  var e = create_element('div', data);
  e.className = 'contento-object-block';

  e.widget = [];
  for ( var i = 0 ; i < data.fields.length ; i++ ) {
    var widget = create_type(data.fields[i]);
    e.widget.push(widget);
    var label = document.createElement('span');
    label.className = 'contento-object-label';
    label.innerHTML = widget.contento.label();
    e.appendChild(label);
    var content = document.createElement('div');
    content.className = 'contento-object-content';

    var desc = document.createElement('div');
      desc.innerHTML = widget.contento.desc();
    content.appendChild(desc);
    content.appendChild(widget);
    e.appendChild(content);
  }

  e.tr = function(lang) {
    for ( var i = 0 ; i < e.widget.length ; i++ ) {
      e.widget[i].tr(lang);
    }
  };

  e.get_value = function() {
    var value = {};
    for ( var  i = 0 ; i < e.widget.length ; i++ ) {
      value[e.widget[i].data.field] = e.widget[i].get_value();
    }
    return value;
  };

  e.activate = function() {
    for ( var  i = 0 ; i < e.widget.length ; i++ ) {
      e.widget[i].activate();
    }
  }

  e.set_value = function(value) {
    if ( value === null ) return;
    if ( value instanceof Object ) {
      for ( var  i = 0 ; i < e.widget.length ; i++ ) {
        var w = e.widget[i];
        if ( w.data.field in value )
          w.set_value(value[w.data.field]);
      }
    }
  };

  e.display_fields = function() {
    var r = [];
    for ( var i = 0 ; i < e.widget.length ; i++ ) {
      var data = e.widget[i].data;
      if ( data.display === true )
        r.push(data);
    }
    return r;
  };

  e.field_label = function(field) {
    for ( var i = 0 ; i < e.widget.length ; i++ ) {
      var data = e.widget[i].data;
      if ( data.field === field )
        return e.widget[i].contento.label();
    }
    return field;
  };

  e.display_value = function() {
    var r = {};
    for ( var i = 0 ; i < e.widget.length ; i++ ) {
      var data = e.widget[i].data;
      if ( data.display === true )
        r[data.field] = w.widget[i].get_value();
    }
    return r;
  };

  return e;
};


*/

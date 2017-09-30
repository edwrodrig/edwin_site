<?php

namespace ephp\web\contento;

require_once(__DIR__ . '/InputString.php');
require_once(__DIR__ . '/InputBool.php');
require_once(__DIR__ . '/InputId.php');
require_once(__DIR__ . '/InputDate.php');
require_once(__DIR__ . '/InputDateTime.php');
require_once(__DIR__ . '/InputTime.php');
require_once(__DIR__ . '/InputObject.php');
require_once(__DIR__ . '/InputEnum.php');
require_once(__DIR__ . '/InputList.php');
require_once(__DIR__ . '/InputInteger.php');
require_once(__DIR__ . '/InputGender.php');

class Input {

public $data;
public $container;


function __construct($data) {
  $this->data = $data;
  $this->container = tag(['class' => ['contento-input'],'contento-type' => $this->data->json()], '#');
}

function js_elem() {
  return 'CONTENTO_UI.get_element(' . js($this->container) . ')';
}

function is_ref() {
  return $this->data->is_ref();
}

function __invoke() {
  $this->container->open();
    t__('label');
      echo tr($this->data->label());
      if ( $this->data->required() ) {
        \ephp\web\Fa::icon('asterisk');
        tag('small')(tr(['es' => 'requerido', 'en' => 'required']));
      }
    __t();
    tag()(tr($this->data->data['desc'] ?? ''));
    $this->content();
  $this->container->close();
  $this->js_functions();
  $this->js_script();
  return $this;
}

function debug_buttons($set_value = 'hola') {
  tag('button' , ['onclick' => sprintf('console.log(%s.get())', js($this))])('Get');
  tag('button' , ['onclick' => sprintf('console.log(%s.set(%s))', js($this), json_encode($set_value))])('Set');
}

function js_functions() {
if ( dg() ) : ?>
<script>
var CONTENTO_UI = (function() {
  return {
    type : {
      default : function(node, type) {
        return {
          type : type,
          node : node,
          get : function() { return this.node.value; },
          set : function(value) { this.node.value = value; },
          clear : function() { this.set(''); }
        };
      }
    },
    get_element : function(element) {
      if ( element.nodeType != 1 ) return null;
      var type = JSON.parse(element.getAttribute('contento-type'));
      if ( type == null ) return null;
      var node = element.children[2];
      if ( this.type.hasOwnProperty(type['type']) ) {
        return this.type[type['type']](node, type);
      } else {
        return this.type.default(node, type);
      }
    }
  };

})();
</script>
<?php

endif;

}

function js_script() {}

function content() {;}

static function create($data) {
  $type = $data->type();
  if ( $type == 'string') {
    return new InputString($data);
  } else if ( $type == 'bool' ) {
    return new InputBool($data);
  } else if ( $type == 'id' ) {
    return new InputId($data);
  } else if ( $type == 'date' ) {
    return new InputDate($data);
  } else if ( $type == 'object' ) {
    return new InputObject($data);
  } else if ( $type == 'enum' ) {
    return new InputEnum($data);
  } else if ( $type == 'list' ) {
    return new InputList($data);
  } else if ( $type == 'integer' ) {
    return new InputInteger($data);
  } else if ( $type == 'datetime' ) {
    return new InputDateTime($data);
  } else if ( $type == 'time' ) {
    return new InputTime($data);
  } else if ( $type == 'gender' ) {
    return new InputGender($data);
  } else {
    $function_name = __NAMESPACE__ . '\custom_input\\' . $type;
    if ( function_exists($function_name) ) {
      return $function_name($data); 
    } else {
      return new Input($data);
    }
  }
}

}

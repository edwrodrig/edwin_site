<?php

namespace ephp\web\contento;

class InputString extends Input {

static function html_include() {
  \ephp\web\ProcFile::register(__DIR__ . '/../../files', 'js/tinymce');
?>
<script src='/js/tinymce/tinymce.min.js'></script>
<?php
}

function content() {
  t__();
  $style = $this->data->style() ;
  if ( $style == 'area' ) {
    tag('textarea')();
  } else if ( $style == 'rich' ) {
    $textarea = tag('textarea', '#')();
?>
<script>
tinymce.init({
  selector : '#<?=js($textarea)->id()?>',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
});
</script>
<?php    
  } else {
    tag('input', ['type' => 'text'])();
  }

  if ( $this->data->data['tr'] ?? false ) {
    t__();
      \ephp\web\Fa::icon('flag');
      t__('select', ['onchange' => js($this)('tr(this.value)')]);
      foreach ( \ephp\Format::$langs as $option ) {
        tag('option', ['value' => $option['value']])(tr($option['label'] ?? $option['value']));
      }
      __t();
    __t();
  }
  __t();
}

function js_functions() {
if ( dg() ) : 
  parent::js_functions();
?>
<script>
CONTENTO_UI.type.string = function(node, type) {
  if ( type.style == 'rich' ) {
    node = node.getElementsByTagName('TEXTAREA')[0];
  } else {
    node = node.children[0];
  }

  if ( type.tr == true ) {
    if ( !node.hasOwnProperty('tr_data') ) node.tr_data = {};
    if ( !node.hasOwnProperty('current_lang') ) node.current_lang = '<?=\ephp\Format::$current_lang?>'; 
  }

  return {
    type : type,
    node: node,
    tr : function(lang) {
      if ( type.tr == true ) {
        this.node.tr_data = this.get();
        this.node.current_lang = lang;
        this.set(this.node.tr_data);
      }
    },
    get : function() {
      var text;
      if ( this.type.style == 'rich' ) text = tinymce.get(this.node.id).getContent();
      else text = this.node.value;
      
      if ( this.type.trim == true ) text = text.trim();

      if ( type.tr == true ) {
        this.node.tr_data[this.node.current_lang] = text;
        text = this.node.tr_data;
      }

      return text;
    },
    set : function(value) {
      if ( this.type.tr == true ) {
        this.node.tr_data = value;
        if ( !this.node.tr_data.hasOwnProperty(this.node.current_lang) ) this.node.tr_data[this.node.current_lang] = '';
        value = this.node.tr_data[this.node.current_lang];
        if ( value == null ) value = '';
      }
      
      if ( this.type.style == 'rich' ) tinymce.get(this.node.id).setContent(value);
      else this.node.value = value;
    },
    clear : function() {
      if ( this.type.tr == true ) this.set({});
      else this.set('');
    }
  };
};
</script>
<?php

endif;
}

}


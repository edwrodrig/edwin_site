<?php

namespace theme\contento;

class TemplateImage extends TemplateMainWithTools {

public $img;
public $button;
public $form;

function __construct() {
  parent::__construct();
  $this->closable = true;
}

function head() {
  parent::head();
  TemplateCommon::style_items();
}

function body($content = '') {
  $this->form = t__('form', '#', ['class' => 'contento-input-object', 'onsubmit' => 'do_action();event.preventDefault()', 'method' => 'post', 'enctype' => 'multipart/form-data']);
    t__(['class' => 'contento-input']);
      tag('label')(tr(['es' => 'vista preeliminar', 'en' => 'preview']));
      $this->img = tag('img', '#', ['width' => 300])();
    __t();
    t__(['class' => 'contento-input']);
      tag('label')(tr(['es' => 'archivo', 'en' => 'file']));
      tag('input', ['type' => 'file', 'name' => 'file', 'onchange' => 'update_preview(this)'])();
    __t();
    t__(['class' => 'contento-input']);
      tag('label')(tr(['es' => 'descripción', 'en' => 'description']));
      tag('input', ['type' => 'text', 'name' => 'description'])();
    __t();
    t__(['class' => 'contento-input']);
      tag('label')(tr(['es' => 'tamaños', 'en' => 'sizes']));
      tag('input', ['type' => 'text', 'name' => 'sizes', 'value' => '{}'])();
    __t();
  __t();
}

function section_buttons() {
  $this->button = $this->fragment_button(tr(['es' => 'Subir', 'en' => 'Upload']), ['onclick' => 'do_action()', 'class' => 'button-primary'], '#');
  $this->fragment_button(tr(['es' => 'Ver original', 'en' => 'View original']), ['onclick' => 'view_original_image()']);

}

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
  (new \theme\contento\Client)();
?>
<script>
function init() { check(); }

function update_preview(input) {
  console.log(input);
  if (input.files && input.files[0]) {
    var reader = new FileReader();
      
    reader.onload = function (e) {
      <?=js($this->img)?>.setAttribute('src', e.target.result);
    }
      
    reader.readAsDataURL(input.files[0]);
  }
}

function view_original_image() {
  window.open(CONTENTO_CLIENT.get_image_url(elem_id), '_blank');
}

function do_action() {
  if ( elem_id == '') action_add();
  else action_edit();
}

function action_add() {
  <?=\theme\app\TemplateModalAction::launch_in_iframe(
    tr(['es' => 'Agregando...', 'en' => 'Adding...']),
    tr(['es' => 'Imagen agregada', 'en' => 'Image added'])
  );
  ?>;
  var data = <?=js($this->form)?>;
  var form = new FormData(data);
 
  CONTENTO_CLIENT.add_image(
    form,
    {
      success: function(data) {
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
        IFRAME_MANAGER_CHILD.signal('slot_element_selected', data);
      },
      error : function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
      }
    }
  );
}

function action_edit() {
  <?=\theme\app\TemplateModalAction::launch_in_iframe(
    tr(['es' => 'Guardando...', 'en' => 'Saving...']),
    tr(['es' => 'Imagen guardade', 'en' => 'Image saved'])
  );
  ?>;

  var data = <?=js($this->form)?>;
  var form = new FormData(data);

  var has_file = form_element.elements[0].files.length > 0;

  if ( has_file ) {
    CONTENTO_CLIENT.edit_image_file(
      elem_id,
      form,
      {
        success: function(data) {
          IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
          IFRAME_MANAGER_CHILD.signal('slot_element_selected', data);
        },
        error : function(data) {
          console.log(data);
          IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message);
          IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
        }
      }
    );
  } else {
    CONTENTO_CLIENT.edit_image(
      elem_id,
      {
        description : form_element.elements[1].value,
        sizes : form_element.elements[2].value
      },
      {
        success: function(data) {
          IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
          IFRAME_MANAGER_CHILD.signal('slot_element_selected', data);
        },
        error : function(data) {
          console.log(data);
          IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message);
          IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');

        }
      }
    );
  }
}

var elem_id = '';

function check() {
  elem_id = CONTENTO_CLIENT.get_token();
  if ( elem_id == '') {
    slot_change_page('main');
    return;
  } else {
    <?=js($this->button)?>.innerHTML = '<?=tr(['es' => 'Guardar', 'en' => 'Save'])?>';
    slot_change_page('first');

    CONTENTO_CLIENT.get_image(
      elem_id,
      {
        success: function(data) {
          <?=js($this->img)?>.setAttribute('src', 'data:image/jpg;base64,' + data.thumbnail);
          <?=js($this->form)?>.children[2].value = data.description;
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

</script>
<?php

}


}

<?php

namespace theme\usac;

class Util {

static function js_function_validate_passwords() {
if ( dg() ) :
?>
<script>
function validate_passwords(form_id) {
  var elements = document.getElementById(form_id).elements;
  var message = ''
  if ( elements['password'].value != elements['password_2'].value ) {
    message = '<?=tr(['es' => 'Las contraseñas no coinciden', 'en' => "Passwords don't match"])?>';
  } else if ( elements['password'].value == "" ) {
    message = '<?=tr(['es' => 'La contraseña no puede ser vacía', 'en' => "Password can't be empty"])?>';
  }
  if ( message == '' ) {
    return true;
  } else {
    IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', message);
    IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
    return false;
  }
} 
</script>
<?php
endif;
}

}

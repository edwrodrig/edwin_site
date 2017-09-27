<?php

namespace theme\usac;

class TemplateModalSessionError extends \theme\app\TemplatePage {

function __construct() {
  parent::__construct();
  $this->body->set(['background-color' => 'rgba(0,0,0,0.5)']);
}

function body($content = '') {
  $this->fragment_dialog('hourglass-end', tr(['es' => 'Su sesión a expirado', 'en' => 'Your session has expired']), function() {
    $this->fragment_button(tr(['es' => 'Reingresar', 'en' => 'Log in']), ['onclick ' => 'slot_login()', 'class' => 'button-primary']);
  });

}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_child();
?>
<script>
function slot_login_success() {
  IFRAME_MANAGER_CHILD.signal('slot_login_success');
  IFRAME_MANAGER_CHILD.close();
}


function slot_login() {
  if ( EPHP_USAC_CLIENT.is_user_logged() ) {
    slot_login_success();     
  } else {
    <?=TemplateModalLogin::launch_in_iframe()?>;
  }  
}
</script>
<?php
}

}

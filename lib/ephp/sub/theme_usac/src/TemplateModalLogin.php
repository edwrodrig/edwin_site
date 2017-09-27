<?php

namespace theme\usac;

class TemplateModalLogin extends \theme\app\TemplatePageStacked {

public $form;

function __construct() {
  parent::__construct();
  $this->body->set(['style' => ['background-color' => 'rgba(0,0,0,0.5)']]);
}

function fragment_form() {
  t__(['class' => ['section-container-narrow', 'container-padding', ['width' => '100%', 'height' => '100%']]]);
  t__(['class' => ['layout-column', 'layout-center', ['width' => '100%', 'height' => '100%']]]);
    $this->form = $this->fragment_form_basic(
      tr(['es' => 'Ingreso de usuario', 'en' => 'User login']),
      function() {
        t__();
          tag('label', ['class' => 'form-label'])(tr(['en' => 'Username', 'es' => 'Nombre de usuario']));
          tag('input', ['class' => 'form-control', 'type' => 'text', 'name' => 'username', 'placeholder' => tr(['es' => 'Nombre de usuario', 'en' => 'Username'])])();
        __t();
        t__();
          tag('label', ['class' => 'form-label'])(tr(['en' => 'Password', 'es' => 'Contraseña']));
          tag('input', ['class' => 'form-control', 'type' => 'password', 'name' => 'password', 'placeholder' => tr(['es' => 'Contraseña', 'en' => 'Password'])])();
        __t();
      },
      function() {
        $this->fragment_button(tr(['en' => 'Login', 'es' => 'Ingresar']), ['onclick' => 'login()', 'class' => 'button-primary']);
        if ( Site::$guest_enabled ) {
          $this->fragment_button(tr(['en' => 'Login as guest', 'es' => 'Ingresar como invitado']), ['onclick' => 'login(true)']);
        }
      },
      function() {
        if ( Site::$signin_enabled ) {
          tag('a', ['onclick' => 'IFRAME_MANAGER_CHILD.signal("slot_go_to", "/user_request_signin.html")'])(tr(['es' => 'Registrate', 'en' => 'Sign in']));
          echo ' | ';
        }
        tag('a', ['onclick' => 'IFRAME_MANAGER_CHILD.signal("slot_go_to", "/user_forgot_password.html")'])(tr(['es' => 'Olvidaste tu contraseña', 'en' => 'Forgot your password']));
      }
    );
  __t();
  __t();
}



function fragment_error() {
  $this->fragment_dialog('warning', tr(['es' => 'Error al ingresar', 'en' => 'Error at login']), function() {
    tag('#placeholder_error_message', 'p')();
    $this->fragment_button(tr(['es' => 'Reintentar', 'en' => 'Retry']), ['onclick' => 'slot_change_page("first")', 'class' => ['button-primary']]);
  });
}

function body($content = '') {
  t__(['name' => 'first']);
    $this->fragment_form();
  __t();
  t__(['name' => 'wait']);
    $this->fragment_dialog_wait(tr(['es' => 'Ingresando...', 'en' => 'Logging in...']));
  __t();
  t__(['name' => 'error']);
    $this->fragment_error();
  __t();
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_child();
  (new \ephp\web\usac\Client)();
?>
<script>
function login(guest = false) {
  var config = {
    success: function(data) {
      IFRAME_MANAGER_CHILD.signal('slot_login_success');
      IFRAME_MANAGER_CHILD.close();
    },
    error: function(data) {
      var message = '<?=tr(['es' => 'A ocurrido un error', 'en' => 'An error has ocurred'])?>';
      if ( data.message == 'USER_NOT_EXISTS' ) {
        message = '<?=tr(['es' => 'El usuario no existe', 'en' => 'User not exists'])?>';
      } else if ( data.message == 'WRONG_PASSWORD' ) {
        message = '<?=tr(['es' => 'Contraseña incorrecta', 'en' => 'Wrong password'])?>';
      }
      slot_set_placeholder('placeholder_error_message', message);        
      slot_change_page('error');
    }
  };

  slot_change_page('wait');
  if ( guest ) {
    EPHP_USAC_CLIENT.user_login_guest(config);
  } else {
    EPHP_USAC_CLIENT.user_login(EPHP_USAC_CLIENT.form_to_json('<?=js($this->form)->id()?>'), config);
  }
}
</script>
<?php
}

}

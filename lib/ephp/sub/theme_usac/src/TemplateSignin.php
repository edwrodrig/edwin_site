<?php

namespace theme\usac;

class TemplateSigninModal extends \theme\tokac\TemplateModalAction {

function fragment_wait() {
  $this->fragment_dialog_wait(tr(['es' => 'Registrando...', 'en' => 'Signing in...']));
}

function fragment_success() {
  $this->fragment_dialog(
    'sign-in',
    tr(['es' => 'Has sido registrado', 'en' => 'You have been registered']),
    function() {
      tag('p')(tr(['es' => 'Ahora puedes ingresar al sitio con tu nuevo usuario y contraseña', 'en' => 'Now you can login to the site with your new user and password']));
      $this->fragment_button(tr(['es' => 'Ingresar', 'en' => 'Login']), ['class' => ['button-primary'], 'onclick' => 'IFRAME_MANAGER_CHILD.signal("slot_go_to", "/login.html")']);
    }

  );
}

}

class TemplateSignin extends TemplatePageTokac {

public $form;

function body($content = '') {
t__(['class' => ['section-container-narrow', 'container-padding']]);
  $this->bottom_up_call('header');
  $this->form = t__('form', '#');
  t__('fieldset', ['class' => ['component']]);
    t__(['class' => ['grid-padding', 'layout-column']]);
      t__();
        tag(['class' => ['form-legend', 'text-center']])(tr(['es' => 'Registro de usuario', 'en' => 'User signin']));
        tag('label', ['class' => 'form-label'])(tr(['en' => 'Username', 'es' => 'Nombre de usuario']));
        tag('input', ['class' => 'form-control', 'type' => 'text', 'name' => 'username', 'placeholder' => tr(['es' => 'Nombre de usuario', 'en' => 'Username'])])();
      __t();
      t__();
        tag('label', ['class' => 'form-label'])(tr(['en' => 'Password', 'es' => 'Contraseña']));
        tag('input', ['class' => 'form-control', 'type' => 'password', 'name' => 'password', 'placeholder' => tr(['es' => 'Contraseña', 'en' => 'Password'])])();
        tag(['class' => 'form-help'])(tr([
          'en' => 'Type your new password',
          'es' => 'Escribe tu nueva contraseña'
        ]));
      __t();
      t__();
        tag('label', ['class' => 'form-label'])(tr(['en' => 'Repeat password', 'es' => 'Repite tu contraseña']));
        tag('input', ['class' => 'form-control', 'type' => 'password', 'name' => 'password_2', 'placeholder' => tr(['es' => 'Contraseña nuevamente', 'en' => 'Password again'])])();
        tag(['class' => 'form-help'])(tr([
          'en' => 'Type your new password again. It must match with the previous one.',
          'es' => 'Escribe tu nueva contraseña. Debe coincidir con la ingresada anteriormente.'
        ]));
      __t();
      t__(['class' => 'form-padding']);
        t__(['class' => ['layout-row', 'layout-wrap', 'layout-center']]);
          $this->fragment_button(tr(['en' => 'Sign in', 'es' => 'Registrar']), ['onclick' => 'do_action()', 'class' => 'button-primary']);
        __t();
      __t();
    __t();
  __t();
  __t();
__t();
}

function js_functions() {
  parent::js_functions();
  Util::js_function_validate_passwords();
?>
<script>
function do_action() {
  <?=TemplateSigninModal::launch_in_iframe()?>;
  
  if ( !validate_passwords('<?=js($this->form)->id()?>') ) return;

  EPHP_USAC_CLIENT.user_signin(
    EPHP_USAC_CLIENT.form_to_json('<?=js($this->form)->id()?>'),
    {
      success: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
      },
      error: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message' , data.message);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
      }
    }
  );
}
</script>
<?php
}

}

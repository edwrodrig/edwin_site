<?php

namespace theme\usac;

class TemplateForgotPassword extends TemplatePage {

public $form;

function body($content = '') {
t__(['class' => ['section-container-narrow', 'container-padding']]);
  $this->bottom_up_call('header');
  $this->form = $this->fragment_form_basic(
    tr(['es' => 'Recuperación de contraseña', 'en' => 'Password recovery']),
    function() {
      t__();
        tag('label', ['class' => 'form-label'])(tr(['en' => 'Username or mail', 'es' => 'Usuario o correo electrónico']));
        tag('input', ['class' => 'form-control', 'type' => 'text', 'name' => 'user_or_mail'])();
        tag(['class' => 'form-help'])(tr([
          'es' => 'Ingresa tu correo electrónico o usuario para proseguir con el proceso de recuperación de contraseña',
          'en' => 'Type your email address or username to continue with the password recovery process'
        ]));
      __t();
    },
    function() {
      $this->fragment_button(tr(['en' => 'Recover', 'es' => 'Recuperar']), ['onclick' => 'do_action()', 'class' => 'button-primary']);
    },
    function() {
      tag('a', ['onclick' => 'window.history.back()'])(tr(['es' => 'Volver', 'en' => 'Back']));
    }
  );
__t();
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_parent();
  (new \ephp\web\usac\Client)();
?>
<script>
function do_action() {
  <?=\theme\tokac\TemplateModalRequest::launch_in_iframe(tr(['es' => 'Sigue las instrucciones para poder reestablecer tu contraseña.', 'en' => 'Follow the instructions to recover your password.']))?>;
  EPHP_USAC_CLIENT.user_request_change_password(
    EPHP_USAC_CLIENT.form_to_json('<?=js($this->form)->id()?>'),
    {
      success: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_mail',  <?=js($this->form)?>.elements['user_or_mail'].value );
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
      },
      error: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
      }
    }
  );
}
</script>
<?php
}

}

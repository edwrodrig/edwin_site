<?php

namespace theme\usac;

class TemplateChangeMailModal extends \theme\tokac\TemplateModalAction {

function fragment_wait() {
  $this->fragment_dialog_wait(tr(['es' => 'Cambiando tu correo electrónico...', 'en' => 'Changing your email...'])); 
}

function fragment_success() {
  $this->fragment_dialog(
    'envelope',
    tr(['es' => 'Tu correo electrónico a sido cambiado', 'en' => 'Your email has been changed']),
    function() {
      t__('p');
        echo tr(['es' => 'Ahora todas tus notificaciones llegarán a tu cuenta ', 'en' => 'Now, all yout notifications will arrive to yout email address' ]);
        tag('#placeholder_mail', 'strong')();
      __t();
      $this->fragment_button(tr(['es' => 'Ingresar', 'en' => 'Login']), ['class' => 'button-primary', 'onclick' => 'IFRAME_MANAGER_CHILD.signal("slot_go_to", "/login.html")']);
    }
  );
}

}

class TemplateChangeMail extends TemplatePageTokac {

public $form;

function body($content = '') {
t__(['class' => ['section-container-narrow', 'container-padding']]);
  $this->form = t__('form', '#');
    t__('fieldset', ['class' => ['component']]);
      t__(['class' => ['grid-padding', 'layout-column', 'text-center']]);
        tag()(tr([
          'es' => 'Solicitaste cambiar el correo electronico asociado a tu cuenta a:',
          'en' => 'You requested to change the email associated to your account to:'
        ]));
        tag('#placeholder_mail', 'h1')();
        tag()(tr([
          'es' => '¿Estás seguro?',
          'en' => 'Are you sure?'
        ]));
        t__(['class' => ['form-padding']]);
          t__(['class' => ['layout-row', 'layout-wrap', 'layout-center']]);
            $this->fragment_button(tr(['en' => 'Confirm change', 'es' => 'Confirmar cambio']), ['class' => 'button-primary', 'onclick' => 'do_action()']);
          __t();
        __t();
      __t();
    __t();
  __t();
__t();
}

function js_functions() {
  parent::js_functions();
?>
<script>
function check(data) {
  slot_set_placeholder('placeholder_mail', data.mail);
  IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_mail', data.mail );
}

function do_action() {
  <?=TemplateChangeMailModal::launch_in_iframe()?>;
  EPHP_USAC_CLIENT.user_change_mail(
    {
      success: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
      },
      error: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_error_message', data.message );
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
      }
    }
  );
}
</script>
<?php
}

}

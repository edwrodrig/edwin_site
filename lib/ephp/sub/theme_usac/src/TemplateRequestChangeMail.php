<?php

namespace theme\usac;

class TemplateRequestChangeMail extends TemplatePage {

public $form;

function body($content = '') {
t__(['class' => ['section-container-narrow', 'container-padding']]);
  $this->bottom_up_call('header');
  $this->form = $this->fragment_form_basic(
    tr(['es' => 'Cambiar correo electrónico', 'en' => 'Change email']),
    function() {
      t__();
        tag('label', ['class' => 'form-label'])(tr(['en' => 'Email', 'es' => 'Correo electrónico']));
        tag('input', ['class' => 'form-control', 'type' => 'text', 'name' => 'mail', 'placeholder' => tr(['es' => 'Email', 'en' => 'Correo electrónico'])])();
        tag(['class' => 'form-help'])(tr([
          'es' => 'Ingresa tu nuevo correo electrónico',
          'en' => 'Type your new email address'
        ]));
      __t();
    },
    function() {
      $this->fragment_button(tr(['en' => 'Solicitar cambio', 'es' => 'Request change']), ['onclick' => 'do_action()', 'class' => 'button-primary']);
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
  <?=\theme\tokac\TemplateModalRequest::launch_in_iframe(tr(['es' => 'Sigue las instrucciones para continuar con el procesos de cambio de correo.', 'en' => 'Follow the instructions to change your mail.']))?>;
  EPHP_USAC_CLIENT.session_request_change_mail(
    EPHP_USAC_CLIENT.form_to_json('<?=js($this->form)->id()?>'),
    {
      success: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_mail', <?=js($this->form)?>.elements['mail'].value);
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

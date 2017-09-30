<?php

namespace theme\tokac;

class TemplatePage extends \theme\app\TemplatePageWithLoading {


function section_wait() {
  $this->fragment_page_wait(tr(['es' => 'Verificando...', 'en' => 'Checking...']));
}

function js_functions() {
  parent::js_functions();
  (new \ephp\web\tokac\Client)();
?>
<script>
function init() {
  EPHP_TOKAC_CLIENT.entry_check({
    success: function(data) {
      console.log(data);
      if (typeof check === 'function') check(data);
      slot_change_page('main');
    },
    error: function(data) {
      console.log(data);
      var message = data.message;
      if ( message == 'ENTRY_NOT_EXISTS' ) {
        message = '<?=tr(['es' => 'Esta solicitud ya se ha completado o ha expirado.', 'en' => 'This request is completed or expired.'])?>';
      }
      slot_set_placeholder('placeholder_error_message', message);
      slot_change_page('error');
    }
  });
}
</script>
<?php
}


}

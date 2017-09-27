<?php

namespace theme\tokac;

class TemplateModalAction extends \theme\app\TemplateModalAction {

function __construct($wait_message = '', $success_content = null) {
  parent::__construct($wait_message);
  $this->success_content = $success_content;
}

function fragment_success() {
  \ephp\web\Util::ob_safe($this->success_content);
}

function fragment_error() {
  $this->fragment_dialog(
    'warning',
    tr(['es' => 'Ha ocurrido un problema', 'en' => 'A problem has occurred']),
    function() {
      tag('#placeholder_error_message', 'p')();
      $this->fragment_button(
        tr(['es' => 'Reintentar', 'en' => 'Retry']),
        [
          'onclick' => 'IFRAME_MANAGER_CHILD.close()',
          'class' => ['button-primary']
        ]
      );
    }
  );
}

}

<?php

namespace theme\contento;

class TemplateMainWithTools extends \theme\app\TemplatePageWithLoading {

public $closable = false;

function body($content = '') {
  t__(['class' => ['grid-padding', 'layout-row'], 'style' => ['height' => '100%']]);
    t__(['class' => [['overflow-y' => 'auto', 'overflow-x' => 'hidden', 'height' => '100%', 'flex-grow' => 1]]]);
      echo $content;
    __t();
    t__(['class' => ['layout-column', 'grid-padding']]);
      $this->section_buttons();
      $this->fragment_button(tr(['es' => 'Recargar', 'en' => 'Reload']), ['onclick' => 'check()']);
      if ( $this->closable )
        $this->fragment_button(tr(['es' => 'Cerrar', 'en' =>'Close']), ['onclick' => 'IFRAME_MANAGER_CHILD.close()']);
    __t();
  __t();
}

function section_buttons() {
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_child();
?>
<script>
function init() { check(); }
</script>
<?php
}

}

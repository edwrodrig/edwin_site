<?php

class TemplateModal extends \theme\app\TemplateModalAction {
  function __construct() {
    parent::__construct();
  }

  function fragment_success() {
    $this->fragment_dialog('facebook', 'Alguna cosa', function() {
      tag('#placeholder_something', 'p')();
      tag('#placeholder_other', 'p')();
      $this->fragment_button(
         tr(['es' => 'Continue', 'en' => 'Continue']),
         ['class' => ['button-primary'], 'onclick' => 'error()']
      );
    });
  }

  function js_functions() {
    parent::js_functions();
?>
<script>
function error() {
  slot_set_placeholder('placeholder_error_message', 'some error');
  slot_change_page('error');
}
</script>
<?php
  }
}

(new class extends \theme\app\TemplatePageWithLoading {

function section_wait() {
  $this->fragment_page_wait('Verifying...');  
}

function body($content = '') {
  $this->fragment_page('rocket', 'Something', function() {
    $this->fragment_button('Launch Modal', ['onclick' => 'open_iframe()']);
  });
}

function js_functions() {
  parent::js_functions();
?>
<script>
function open_iframe() {
  <?=TemplateModal::launch_in_iframe()?>;
  IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_something', 'wachulerun');
  IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', 'placeholder_other', 'wey');
  setTimeout(function() { IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success')}, 2000);

}
</script>
<?php
}

function js_script() {
  parent::js_script();
?>
<script>
setTimeout(function() { slot_change_page('main'); }, 2000);
</script>
<?php
}

})->print();

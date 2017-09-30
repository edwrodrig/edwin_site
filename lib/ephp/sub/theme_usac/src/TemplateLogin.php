<?php

namespace theme\usac;

class TemplateLogin extends TemplatePage {

public $target = '/main.html';

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_parent();
?>
<script>
function slot_login_success() {
  slot_go_to('<?=$this->target?>');
}
</script>
<?php
}

function js_script() {
  parent::js_script();
?>
<script>
<?=TemplateModalLogin::launch_in_iframe()?>;
</script>
<?php

}

}

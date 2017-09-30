<?php

namespace theme\app;

class TemplateSigned extends TemplatePage {

public $user_label;

function __construct() {
  parent::__construct();
  $this->user_label = tag('#');

}

function nav($content = '') {
  echo $content;
}

function body($content = '') {
t__(style_def(['background-color' => '#54b4eb']));
  $this->bottom_up_call('nav');
  ($this->user_label)();
  tag('a', ['onclick' => 'SESSION_MANAGER.logout()'])(tr(['es' => 'Salir', 'en' => 'Logout']));
__t();
echo $content;
}

function modal_session_expired() {
  return $this->modal_generic_action(
           tr(['es' => 'Su sesión a expirado', 'en' => 'Your session has expired']),
           null,
           [['onclick' => 'relogin()', 'text' => tr(['es' => 'Reingresar', 'en' => 'Re login'])]]
  );
}

function js_check_function() {
?>
function() {
  EPHP_USAC_CLIENT.session_check({
    success: function(data) {
      <?=$this->overlay->js_close()?>;
      SESSION_MANAGER.update_ui();
    },
    error: function(data) {
      console.log(data);
      <?=$this->modal_session_expired()?>;
    }
  });
}
<?php
}

function js_functions() {
  parent::js_functions();
  (new \ephp\web\usac\Client)();
?>
<script>
function relogin() {
  if ( EPHP_USAC_CLIENT.is_user_logged() ){
    <?=$this->js_check()?>;
  } else {
    window.open("/login.html");
  }
}

var SESSION_MANAGER = {
  update : function(data) {
    EPHP_USAC_CLIENT.set_username(data.username);
    EPHP_USAC_CLIENT.set_session(data.session);
    this.check();
  },
  check : <?=$this->js_check_function()?>,
  update_ui : function() {
     <?=js($this->user_label)?>.innerHTML = EPHP_USAC_CLIENT.get_username();
  },
  logout : function() {
    <?=$this->modal_wait(tr(['es' => 'Saliendo', 'en' => 'Logging out']))?>;
    EPHP_USAC_CLIENT.session_logout({
      success: function(data) {
        window.location.replace("/login.html");
      },
      error: function(data) {
        window.location.replace("/login.html");
      }
    });
  }
};
</script>
<?php
}

function js_script() {
?>
<script>
<?=$this->js_check()?>
</script>

<?php
  parent::js_script();
}

function js_check() {
  return 'SESSION_MANAGER.check()';
}

}

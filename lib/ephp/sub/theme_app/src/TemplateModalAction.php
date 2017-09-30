<?php

namespace theme\app;

class TemplateModalAction extends TemplatePageStacked {

public $wait_message;
public $success_title;
public $success_content;

function __construct($wait_message = null, $success_title = null, $success_content = null) {
  parent::__construct();
  $this->body->set(['style' => ['background-color' => 'rgba(0,0,0,0.5)']]);
  $this->wait_message = $wait_message;
  $this->success_title = $success_title;
  $this->success_content = $success_content;
} 

function fragment_wait() {
  $this->fragment_dialog_wait($this->wait_message);
}

function fragment_error() {
  $this->fragment_dialog('warning', tr(['es' => 'Ha ocurrido un error', 'en' => 'An error has occurred']), function() {
    tag('#placeholder_error_message', 'p')();
    $this->fragment_button_ok(['class' => 'button-primary']);
  });
}

function fragment_success() {
  $this->fragment_dialog(
    'check',
    $this->success_title,
    function() {
      \ephp\web\Util::ob_safe($this->success_content);
      $this->fragment_button_ok(['class' => 'button-primary']);
    }
  );
}

function body($content = '') {
  t__(['name' => 'first']);
    $this->fragment_wait(); 
  __t();
  t__(['name' => 'success']);
    $this->fragment_success();
  __t();
  t__(['name' => 'error']);
    $this->fragment_error();
  __t();
}

function js_functions() {
  parent::js_functions();
  \ephp\web\Iframe::js_functions_child();
}

}

<?php

namespace theme\tokac;

class TemplateModalRequest extends TemplateModalAction {

public $success_message;

function __construct($success_message = '') {
  parent::__construct(tr(['es' => 'Solicitando...', 'en' => 'Requesting...']));
  $this->success_message = $success_message;
}

function fragment_success() {
  $this->fragment_dialog('envelope', tr(['es' => 'Revisa tu correo', 'en' => 'Check your mail']), function() {
    t__('p');
      echo tr(['es' => "Te hemos enviado un correo a la dirección ", 'en' => 'We have sended a mail to your account ']);
      tag('strong', '#placeholder_mail')();
      echo ". ";
      echo  $this->success_message;
      echo " ";
      echo tr(['es' => "Si no te ha llegado un correo en los próximos minutos puedes reintentarlo.", 'en' => 'If the mail has not arrived in the next minutes you can try again.']);
    __t();
    $this->fragment_button(tr(['en' => 'Return to home', 'es' => 'Volver al inicio']), ['onclick' => 'IFRAME_MANAGER_CHILD.signal("slot_back")', 'class' => 'button-primary']);
  });
}

}

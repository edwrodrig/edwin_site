<?php

namespace ephp\usac {

/*
Controlador de request de mail
*/
class MailTemplates {

public $page_url = 'http://localhost:8080';
public $from_text = ['es' => 'Sistema de cuentas de usuario', 'en' => 'User account system'];

function user_request_signin($data) {
  return [
    'from' => ['text' => tr($this->from_text)],
    'to' => ['text' => tr(['es' => 'Nuevo usuario', 'en' => 'New user']), 'mail' => $data['mail'] ],
    'subject' => tr(['es' => 'Solicitud de registro', 'en' => 'Sign in request']),
    'plain' => tr([
      'es' => \ephp\web\Util::ob_safe(function() use($data) {
?>
Hola,

Hemos recibido una solicitud de registro para tu correo <?=$data['mail']?>. Si ese es el caso, por favor ingresa al siguiente link para continuar el proceso de registro:

<?=$this->page_url?>/user_signin.html?<?=$data['token']?>
<?php
      }),
      'en' => \ephp\web\Util::ob_safe(function() use($data) {
?>
Hello,

We have received a sign in request for your mail <?=$data['mail']?>. If that the case, please go to the following link to continue the sign in process:

<?=$this->page_url?>/user_signin.html?<?=$data['token']?>
<?php
      })
    ])
  ];
}

function user_request_change_password($data) {
  return [
    'from' => ['text' => tr($this->from_text)],
    'to' => ['text' => $data['username'], 'mail' => $data['mail'] ],
    'subject' => tr(['es' => 'Solicitud de cambio de contraseña', 'en' => 'Change password request']),
    'plain' => tr([
      'es' => \ephp\web\Util::ob_safe(function() use($data) {
?>
Hola,

Hemos recibido una solicitud para reestablecer tu contraseña. Si ese es el caso, por favor ingresa al siguiente link para continuar el proceso:

<?=$this->page_url?>/user_change_password.html?<?=$data['token']?>
<?php
      }),
      'en' => \ephp\web\Util::ob_safe(function() use($data) {
?>
Hello,

We have received a request for changing your password. If that the case, please go to the following link to continue the process:

<?=$this->page_url?>/user_change_password.html?<?=$data['token']?>
<?php
      })
    ])
  ];

}

function user_request_change_mail($data) {
  return  [
    'from' => ['text' => tr($this->from_text)],
    'to' => ['text' => $data['username'], 'mail' => $data['mail'] ],
    'subject' => tr(['es' => 'Confirmación de cambio de correo', 'en' => 'Change mail confirmation']),
    'plain' => tr([
      'es' => \ephp\web\Util::ob_safe(function() use($data) {
?>
Hola,

Hemos recibido una solicitud para cambiar tu correo a <?=$data['mail']?>. Si ese es el caso, por favor ingresa al siguiente link para continuar el proceso:

<?=$this->page_url?>/user_change_mail.html?<?=$data['token']?>
<?php
      }),
      'en' => \ephp\web\Util::ob_safe(function() use($data) {
?>
Hello,

We have received a request for changing your mail to <?=$data['mail']?>. If that the case, please go to the following link to continue the process:

<?=$this->page_url?>/user_change_mail.html?<?=$data['token']?>
<?php
      })
    ])
  ];

}

}

}


<?php

namespace theme\usac;

class Site {

static public $guest_enabled = true;
static public $signin_enabled = true;
public $logo_content = '';

function __construct() {
  $this->logo_content = function() {
    tag('h1', ['class' => ['page_header'] , 'style' => ['text-align' => 'center']])(
      tr([
        'es' => 'Cuentas de usuario',
        'en' => 'User accounts'
      ])
    );
  };
}

function generate() {

$logo = function() { \ephp\web\Util::ob_safe($this->logo_content); };


\ephp\web\Context::file_process('/login.html', function() use($logo) {
  $page = new TemplateLogin;
  $page->print();

});


\ephp\web\Context::file_process('/user_change_mail.html', function() use($logo) {
  $page = new TemplateChangeMail;
  $page->template_content['header'] = $logo;
  $page->print();
});

\ephp\web\Context::file_process('/user_change_password.html', function() use($logo) {
  $page = new TemplateChangePassword;
  $page->template_content['header'] = $logo;
  $page->print();
});

\ephp\web\Context::file_process('/user_forgot_password.html', function() use($logo) {
  $page = new TemplateForgotPassword;
  $page->template_content['header'] = $logo;
  $page->print();
});

\ephp\web\Context::file_process('/user_request_change_mail.html', function() use($logo) {
  $page = new TemplateRequestChangeMail;
  $page->template_content['header'] = $logo;
  $page->print();
});

if ( self::$signin_enabled ) {

  \ephp\web\Context::file_process('/user_request_signin.html', function() use($logo) {
    $page = new TemplateRequestSignin;
    $page->template_content['header'] = $logo;
    $page->print();
  });

  \ephp\web\Context::file_process('/user_signin.html', function() use($logo) {
    $page = new TemplateSignin;
    $page->template_content['header'] = $logo;
    $page->print();
  });

}

}

}


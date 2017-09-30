<?php

class Site extends \theme\usac\Site {

function logo($content = '') {
  tag(['class' => ['page_header'] , 'style' => ['text-align' => 'center']])(
    tr([
      'es' => 'Prueba de cuentas de usuario',
      'en' => 'User accounts Test'
    ])
  );
}

}

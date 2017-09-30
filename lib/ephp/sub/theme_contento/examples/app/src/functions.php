<?php

function logo($context) {
  tag($context->page_header, ['style' => ['text-align' => 'center']])(
    tr([
      'es' => 'Cuentas de usuario',
      'en' => 'User accounts'
    ])
  );
}

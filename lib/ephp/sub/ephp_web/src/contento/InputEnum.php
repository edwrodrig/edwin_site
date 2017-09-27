<?php

namespace ephp\web\contento;

class InputEnum extends Input {

function content() {
  t__('select');
  foreach ( $this->data->options() as $option ) {
    $selected = [];
    if ( ($this->data->data['default'] ?? null) == $option['value'] ) {
      $selected = ['selected' => 'selected'];
    }
    tag('option', ['value' => $option['value']], $selected)(tr($option['label'] ?? $option['value']));
  }
  __t();
}

}

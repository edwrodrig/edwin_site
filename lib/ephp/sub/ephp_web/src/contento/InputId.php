<?php

namespace ephp\web\contento;

class InputId extends Input {

function content() {
  tag('input', ['type' => 'text'])();
}

}


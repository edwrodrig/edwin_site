<?php

namespace ephp\web\contento;

class InputInteger extends Input {

function content() {
  tag('input', ['type' => 'number'])();
}

}


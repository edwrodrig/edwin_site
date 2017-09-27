<?php

namespace ephp\web\contento\custom_input;

require_once(__DIR__ . '/InputRef.php');
require_once(__DIR__ . '/InputImageRef.php');

function ref($data) {
  return new \theme\contento\InputRef($data);
}

function image_ref($data) {
  return new \theme\contento\InputImageRef($data);
}

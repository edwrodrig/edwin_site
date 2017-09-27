<?php

require_once(__DIR__ . '/ephp_mvc/include.php');

class Actions {

function add($arg1, $arg2) {
  return $arg1 + $arg2;;
}

function sub($arg1, $arg2) {
  return $arg1 - $arg2;
}

function sort($arg1, $arg2) {
  return [
    'min' => min($arg1, $arg2),
    'max' => max($arg1, $arg2)
  ];
}

function download() {
  return [
    'type' => 'text/plain',
    'name' => 'prueba.txt',
    'data' => 'hola como te va',
    '__response_type' => 'file'
   ];
}

}

(new class extends \ephp\mvc\Loader {

function http() { return new Actions; }

})();


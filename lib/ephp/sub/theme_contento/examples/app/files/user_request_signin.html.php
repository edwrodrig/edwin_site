<?php

(new class extends \theme\app\TemplateRequestSignin {

function __construct() {
  parent::__construct();
}

function header() {
  logo($this);
}

})->print();

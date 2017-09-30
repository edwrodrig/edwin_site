<?php

(new class extends \theme\app\TemplateSignin {

function __construct() {
  parent::__construct();
}

function header() {
  logo($this);
}

})->print();


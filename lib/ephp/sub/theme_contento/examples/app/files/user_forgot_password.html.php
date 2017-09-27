<?php

(new class extends \theme\app\TemplateForgotPassword {

function __construct() {
  parent::__construct();
}

function header() {
  logo($this);
}

})->print();

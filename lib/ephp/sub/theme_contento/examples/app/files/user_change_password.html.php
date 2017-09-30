<?php

(new class extends \theme\app\TemplateChangePassword {

function __construct() {
  parent::__construct();
}

function header() {
  logo($this);
}

})->print();

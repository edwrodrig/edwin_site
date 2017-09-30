<?php

(new class extends \theme\app\TemplateLogin {

function __construct() {
  parent::__construct();
}

function header() {
  logo($this);
}

})->print();

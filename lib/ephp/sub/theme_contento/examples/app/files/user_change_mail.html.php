<?php

(new class extends \theme\app\TemplateChangeMail {

function __construct() {
  parent::__construct();
}

function header() {
  logo($this);
}

})->print();

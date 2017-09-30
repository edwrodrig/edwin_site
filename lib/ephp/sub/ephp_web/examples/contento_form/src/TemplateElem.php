<?php

class TemplateElem extends \ephp\web\TemplatePage {

function __construct() {
  parent::__construct();
}

function head($content = '') {
?>
<link rel="stylesheet" href="https://dbushell.com/Pikaday/css/pikaday.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script src='https://dbushell.com/Pikaday/pikaday.js'></script>
<?php
  echo $content;
}

}

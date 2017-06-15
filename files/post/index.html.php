<?php

foreach ( Data::forPost() as $data ) {
ephp\web\Builder::page_start($data->link());

(new class($data) extends MyTemplatePage {

public $data;

function __construct($data) {
  $this->data = $data;
  $metadata = ['page' => ['title' => $data->title()]];
  parent::__construct($metadata);

}


function main($content = '') {
  container__()([$this->style_container_padding]);
    tag($this->title, [style(['font-size' => '3em',  'margin-bottom' => '0em'])])($this->data->title());
    tag('time', [style(['display'=> 'block'])])(\ephp\web\Format::date($this->data->date()));
    tag($this->separator)();
    file_put_contents('/tmp/content.php', $this->data->content());
    ob_start();
    include('/tmp/content.php');
    tag($this->paragraph)(ob_get_clean());
  __container();
}

})();

ephp\web\Builder::page_end();

}


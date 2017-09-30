<?php

foreach ( \data()['posts'] as $data ) {
ephp\web\Context::file_process($data['link'], function() use($data) {

(new class($data) extends \edwin\web\TemplatePage {

public $data;

function __construct($data) {
  $this->data = $data;
  $metadata = ['title' => tr($data['title'])];
  parent::__construct($metadata);

}


function body($content = '') {
  t__(['class' => ['section-container']]);
  t__(['class' => ['container-padding']]);
 
    t__(['class' => ['bigger-font']]); 
      tag('h1')(tr($this->data['title']));
      t__('time', ['class' => ['style' => ['font-style' => 'italic']]]);
        \ephp\web\Fa::inline('clock-o'); echo \ephp\Format::date($this->data['date']);
      __t();
    __t();
    tag('hr')();
    file_put_contents('/tmp/content.php', $this->data['content']);
    ob_start();
    include('/tmp/content.php');
    tag(['class' => ['paragraph']])(ob_get_clean());
  __t();
  __t();
}

})->print();

});

}

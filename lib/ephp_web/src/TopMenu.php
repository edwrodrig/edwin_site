<?php
namespace ephp\web;

class TopMenu extends Nav {

function __construct(...$args) {
  parent::__construct([style_def(['position' => 'absolute', 'width' => '100%'])], ...$args);

  $this->item = tag('a', [style_def(['padding' => '0.3em 0.5em'])]);

}

}



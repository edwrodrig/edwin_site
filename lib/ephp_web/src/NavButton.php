<?php
namespace ephp\web;

class NavButton extends Tag {

function __construct(...$args) {
  parent::__construct('button', '#', [
    style_def([
      'padding' => '0.222em',
      'border' => '1px solid transparent',
      'border-radius' => '0.2em',
      '> *' => new Style([
        'width' => '1.5em',
        'height' => '0.333em',
        'border-radius' => '0.06em',
        'margin' => '0.3em'])
    ])
  ]);
}

function __invoke($data = null) {
  parent::__invoke('<div></div><div></div><div></div>');
}


}


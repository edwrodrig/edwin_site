<?php
namespace blog\web;

class ProjectBox {

public $container;
public $img;
public $title;
public $description;

function __construct() {
  $this->container = tag('a', [
    style_def([
      'layout' => 'row',
      'overflow' => 'hidden',
      'text-decoration' => 'none',
      'color' => 'inherit',
      'margin-bottom' => '2.5em',
      '@media (max-width : 500px)' => style(['layout' => 'column']),
      '> *' => style(['overflow' => 'hidden']),
      ':hover' => style(['color' => TemplatePage::$style['highlight_font_color']])
    ])
  ]);
     
  $this->img = tag([
    style_def([
      'background-size' => 'cover',
      'background-position' => 'center',
      'background-repeat' => 'no-repeat',
      'size' => '100px'
    ])
  ]);

  $this->title = tag('h2', [
    style_def([
      'font-family' => "'VT323', monospace",
      'margin' => '0',
      'font-weight' => 'unset'
    ])
  ]);

  $this->description = tag([
    style_def([
      'text-align' => 'justify'
    ])
  ]);
}

function __invoke($data) {
  t__($this->container, ['href' => $data['url']]);
    tag($this->img, [style(['bg-img' => $data['image']])])();
    tag([style_def(['padding' => '0.5em'])])();
    t__();
      tag($this->title)($data['name']);
      tag($this->description)($data['description']);
    __t(); 
  __t();
}


}

<?php
namespace blog\web;

class PostBox {

public $container;
public $title;
public $date;

function __construct(...$args) {
  $this->container = tag('a', [
    style_def([
      'display' => 'block',
      'text-decoration' => 'none',
      'color' => 'inherit',
      'margin-bottom' => '1.5em',
      ':hover' => style(['color' => TemplatePage::$style['highlight_font_color']])
    ])
  ]);

  $this->title = tag('h2', [
    style_def([
      'margin' => '0',
      'font-family' => "'VT323', monospace",
      'font-weight' => 'unset'
    ])
  ]);
  $this->date = tag('time', [style(['display' => 'block'])]);
}

function __invoke($data) {
  t__($this->container, ['href' => url($data['link'])]);
    tag($this->title)($data['title']);
    tag($this->date)(\ephp\web\Format::date($data['date']));
  __t();
}

}

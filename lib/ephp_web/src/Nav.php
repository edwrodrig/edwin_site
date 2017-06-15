<?php
namespace ephp\web;

class Nav extends Template {

public $container;
public $item;

function __construct(...$args) {
  $this->container = tag('nav',...$args);

  $this->item = tag('a', [style_def(['display' => 'block', 'padding' => '0.5em 0.7em', 'white-space' => 'nowrap'])]);

}

function __invoke($elements = null) {
  $this->container->open();
  foreach ( $elements ?? [] as $element ) {
    $content = $element['content'] ?? '';
    unset($element['content']);
    tag($this->item, ['title' => $content ], $element)($content);
  }
  $this->container->close();

}

}


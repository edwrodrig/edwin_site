<?php
namespace ephp\web;

class BoxLabel extends Template {

public $container;
public $label;
public $content;

public function __construct(...$args) {
  $this->container = tag([style_def(['display' => 'flex', 'overflow' => 'hidden', '> *' => style(['overflow' => 'hidden', 'padding' => '1em'])])], ...$args);
  $this->label = tag([style_def(['align' => 'center'])]);
  $this->content = tag();
}

function __invoke($label, $content) {
  $this->container->open();
  ($this->label)($label);
  ($this->content)($content);
  $this->container->close();
}

}

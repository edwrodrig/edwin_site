<?php
namespace ephp\web;

class BoxResume extends Template {

public $container;
public $img;
public $content;

public function __construct(...$args) {
  $this->container = tag(['box-resume-container'], ...$args);
  $this->img = tag(['box-image']);
  $this->content = tag();
}

function __invoke($content) {
  $this->container->open();
  ($this->img)();
  tag([style(['padding' => '0.5em'])])();
  ($this->content)($content);

  $this->container->close();
}

}

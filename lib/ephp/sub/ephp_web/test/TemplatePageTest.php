<?php
require_once(__DIR__ . '/../include.php');

use PHPUnit\Framework\TestCase;


class Template extends \ephp\web\TemplatePage {

function body($content) {
  echo '<h1>', $this->metadata['title'], '</h1><div>',  $content, '</div>';
}

function head($content) {
  echo '<style>some styles</style>', $content;
}

}

class TemplatePageTest extends TestCase {

function testSubTemplate() {
  $s = strval(Template::create(['title' => 'demo', 'lang' => 'es']));

  $this->assertContains('<html>', $s);
  $this->assertContains('<style>some styles</style>', $s);
  $this->assertContains('<body style="padding:0;margin:0;"><h1>demo</h1><div></div></body>', $s);
}


}


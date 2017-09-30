<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\web\Meta;

class MetaTest extends TestCase {

function testMetaDefault() {
  $this->assertContains('charset="UTF-8"', strval(new Meta([])));
}

function testMetaAuthor() {
  $this->assertContains('<meta name="author" content="edwin" />', strval(new Meta(['author' => 'edwin'])));
}

function testMetaDescription() {
  $s = strval(new Meta(['description' => 'some desc', 'site' => ['description' => 'site desc'], 'twitter' => ['type' => 'summary']]));
  $this->assertContains('<meta name="description" content="some desc" />', $s);
  $this->assertContains('<meta name="og:description" content="some desc" />', $s);
  $this->assertContains('<meta name="twitter:description" content="some desc" />', $s);
  $this->assertContains('<meta itemprop="description" content="some desc" />', $s);
}

function testMetaSiteDescription() {
  $s = strval(new Meta(['site' => ['description' => 'some desc'], 'twitter' => ['type' => 'summary']]));
  $this->assertContains('<meta name="description" content="some desc" />', $s);
  $this->assertContains('<meta name="og:description" content="some desc" />', $s);
  $this->assertContains('<meta name="twitter:description" content="some desc" />', $s);
  $this->assertContains('<meta itemprop="description" content="some desc" />', $s);
}

function testMetaSiteTitle() {
  $s = strval(new Meta(['site' => ['title' => 'IMO']]));
  $this->assertContains('<title>IMO</title>', $s);
  $this->assertContains('<meta itemprop="name" content="IMO" />', $s);
}

function testMetaTitle() {
  $s = strval(new Meta(['title' => 'Page']));
  $this->assertContains('<title>Page</title>', $s);
  $this->assertContains('<meta itemprop="name" content="Page" />', $s);
}

function testMetaTitleSiteTitle() {
  $s = strval(new Meta(['title' => 'Page', 'site' => ['title' => 'IMO']]));
  $this->assertContains('<title>Page | IMO</title>', $s);
  $this->assertContains('<meta itemprop="name" content="Page" />', $s);
}



}


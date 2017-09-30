<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase {

function setUp() {
  ephp\web\Tag::reset();
  ephp\web\Style::reset();
  ephp\web\DefineGuard::reset();
}

function testTagDefault() {
  ob_start();
  tag()();
  $this->assertEquals('<div></div>',ob_get_clean());
}

function testTagEmpty() {
  ob_start();
  tag('div')();
  $this->assertEquals('<div></div>',ob_get_clean());
}

function testTagContent() {
  ob_start();
  tag('p')('hello world');
  $this->assertEquals('<p>hello world</p>', ob_get_clean());
}

function testTagWithId() {
  ob_start();
  tag('h1', '#title')('titulo');
  $this->assertEquals('<h1 id="title">titulo</h1>', ob_get_clean(), 'manual id');

  ob_start();
  tag('h2', '#')('auto');
  $this->assertEquals('<h2 id="t0">auto</h2>', ob_get_clean(), 'auto id');
  

  ob_start();
  tag('h3', '#')('auto 2');
  $this->assertEquals('<h3 id="t1">auto 2</h3>', ob_get_clean(), 'auto second id');

  ob_start();
  tag('p', '#a')();
  $this->assertEquals('<p id="a"></p>', ob_get_clean(), 'style id');
}

function testTagOpenClose() {
  ob_start();
  t__('time');
    echo 'some content';
  __t();
  $this->assertEquals('<time>some content</time>', ob_get_clean());
}

function testTagCreateFromTag() {
  $t = tag('#date', 'date');

  ob_start();
  $t('2000');
  $t = clone $t;
  $t('2001');
  $this->assertEquals('<date id="date">2000</date><date>2001</date>', ob_get_clean());
}

function testTagAttr() {
  ob_start();
  tag('a', ['href' => 'http://google.cl'])('Google');
  $this->assertEquals('<a href="http://google.cl">Google</a>', ob_get_clean());
}

function testTagStyleAttr() {
  $t = tag('p', ['style' => ['color' => 'red']]);

  $this->assertEquals(true, $t->style_attr->isset(), 'is set');
  $this->assertEquals(true, $t->style_attr->is_anon(), 'is anon');

  ob_start();
  $t('red box');
  $this->assertEquals('<p style="color:red;">red box</p>', ob_get_clean(), 'first print');

  ob_start();
  $clone = clone $t;
  $clone->set('h', ['style' => ['background-color' => 'black']]);
  $clone('bg box');
  $this->assertEquals('<h style="color:red;background-color:black;">bg box</h>', ob_get_clean(), 'subclass');

  ob_start();
  $t('again box');
  $this->assertEquals('<p style="color:red;">again box</p>', ob_get_clean(), 'again first');
}

function testTagStyleAttrToClass() {
  $t = tag('p', ['style' => ['color' => 'red', ':hover' => ['color' => 'blue']]]);

  $this->assertEquals(true, $t->style_attr->isset(), 'is set');
  $this->assertEquals(true, $t->style_attr->is_anon(), 'is anon');

  ob_start();
  $t('red box');
  $this->assertEquals('<style>.s0{color:red;}.s0:hover{color:blue;}</style><p class="s0">red box</p>', ob_get_clean(), 'first print');

  ob_start();
  $clone = clone $t;
  $clone->set('h', ['style' => ['background-color' => 'black']]);
  $clone('bg box');
  $this->assertEquals('<style>.s1{color:red;background-color:black;}.s1:hover{color:blue;}</style><h class="s1">bg box</h>', ob_get_clean(), 'subclass');


  ob_start();
  $t('again box');
  $this->assertEquals('<style>.s2{color:red;}.s2:hover{color:blue;}</style><p class="s2">again box</p>', ob_get_clean(), 'again first');
}



function testTagStyleClass() {
  $t = tag('p', ['class' => [['color' => 'red']]]);

  ob_start();
  $t('text');
  $this->assertEquals('<style>.s0{color:red;}</style><p class="s0">text</p>', ob_get_clean());

  ob_start();
  $clone = clone $t;
  $clone->set(['class' => [['background-color' => 'blue']]]);

  ($clone)('other');
  $this->assertEquals('<style>.s1{background-color:blue;}</style><p class="s0 s1">other</p>', ob_get_clean());

  ephp\web\Style::reset();

  ob_start();
  ($clone)('another');
  $this->assertEquals('<style>.s0{color:red;}.s1{background-color:blue;}</style><p class="s0 s1">another</p>', ob_get_clean());
}

function testTagManyClasses() {
  $t = tag('p', ['class' => ['some_id', ['color' => 'red']]]);
  
  ob_start();
  $t('text');
  $this->assertEquals('<style>.s0{color:red;}</style><p class="some_id s0">text</p>', ob_get_clean());
  
  ob_start();
  $clone = clone $t;
  $clone->set(['class' => [['background-color' => 'blue']]]);
  
  ($clone)('other');
  $this->assertEquals('<style>.s1{background-color:blue;}</style><p class="some_id s0 s1">other</p>', ob_get_clean());
  
  ephp\web\Style::reset();
  
  ob_start();
  ($clone)('another');
  $this->assertEquals('<style>.s0{color:red;}.s1{background-color:blue;}</style><p class="some_id s0 s1">another</p>', ob_get_clean());
}


function testTagStyleInstantiateClass() {
  $t = tag('p', ['class' => [['color' => 'red']]]);

  ob_start();
  $t->print_styles();
  $this->assertEquals('<style>.s0{color:red;}</style>', ob_get_clean());

  ob_start();
  $t('text');
  $this->assertEquals('<p class="s0">text</p>', ob_get_clean());
}


function testTagLayout() {
  $t =  tag(['class' => [['color' => 'red', '> *' => ['color' => 'blue']]]]);

  ob_start();
  $t('text');
  $this->assertEquals('<style>.s0{color:red;}.s0 > *{color:blue;}</style><div class="s0">text</div>', ob_get_clean());

  $t->set(['class' => [['> *' => ['background-color' => 'white']]]]);
  ob_start();
  $t('text2');
  $this->assertEquals('<style>.s1 > *{background-color:white;}</style><div class="s0 s1">text2</div>', ob_get_clean());

}

function testTagInside() {
  ob_start();
  t__();
    tag('img', ['src' => 'http://some/wachulin.jpg'])();
  __t();
  $this->assertEquals('<div><img src="http://some/wachulin.jpg"/></div>', ob_get_clean());
}

function testTagHtml() {
  $html = tag('html');
  ob_start();
    $html->set(['class' => ['full']]);
    $html->open();
    $html->close();
  $this->assertEquals('<html class="full"></html>', ob_get_clean());

}

function testTagAttrClone() {
  $tag = tag('a', ['href' => 'hola.html']);
  ob_start();
    (clone $tag)('');
  $this->assertEquals('<a href="hola.html"></a>', ob_get_clean());
}

function testTagOnClick() {
  ob_start();
  tag('p', ['onclick' => 'hola'])('');
  $this->assertEquals('<p onclick="hola"></p>', ob_get_clean());
}

function testTagOnClick2() {
  ob_start();
  tag('p', ['onclick' => '"'])('');
  $this->assertEquals('<p onclick="&quot;"></p>', ob_get_clean());
}

function testTag() {
  ob_start();
  tag('nav', ['class' => [['color' => 'red']]])();
  tag('nav', ['class' => [['color' => 'black']]])();
  $this->assertEquals('<style>.s0{color:red;}</style><nav class="s0"></nav><style>.s1{color:black;}</style><nav class="s1"></nav>', ob_get_clean());
}


}



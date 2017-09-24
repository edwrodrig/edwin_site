<?php
namespace theme\blog;

class TemplatePage extends \ephp\web\TemplatePage {

public $nav;
public $title;
public $title_main;
public $title_center;
public $paragraph;
public $button;
public $code_block;
public $separator;
public $style_container_padding;

static public $style = [
  'font_color' => '#AAA',
  'background_color' => 'black',
  'highlight_font_color' => 'yellow',
  'box_background_color' => '#333',
  'box_font_color' => '#AAA',
  'box_highlight_font_color' => 'yellow',
  'font_normal' => "'Cutive Mono', monospace",
  'font_emph' => "'VT323', monospace"
];

static public $base_metadata = [];

function __construct($metadata = []) {
  parent::__construct(array_replace_recursive(self::$base_metadata, $metadata));

  $this->nav = new \ephp\web\NavResponsive('inside');
  $this->nav->mobile->container->set([
    style([
      'bg-color' => self::$style['box_background_color'],
      'box-shadow' => 'inset 0 4px 4px rgba(0,0,0,0.5)'
    ])
  ]);
  $item_style = style_def([
    'color' => 'inherit',
    'text-decoration' => 'none',
    ':hover' => ['bg-color' => self::$style['box_font_color'], 'color' => self::$style['box_background_color'],
  ]);
  $this->nav->mobile->item->set([$item_style]);
  $this->nav->desktop->item->set([$item_style]);
  $this->font_files = ['https://fonts.googleapis.com/css?family=Cutive+Mono|VT323'];
  $this->body->set(['style' => [[
    'font-family' => self::$style['font_normal'],
    'background-color' => self::$style['background_color'],
    'color' => self::$style['font_color'],
  ]);

  $this->nav->button->set([
    style_def([
      'margin' => '0.5em',
      'border-color' => self::$style['box_font_color'],
      'background-color' => 'transparent',
      '> *' => style(['bg-color' => self::$style['box_font_color']]),
      ':hover' => style([
        'background-color' => 'rgba(0,0,0,0.15)',
        'border-color' => self::$style['box_highlight_font_color'],
        '> *' => style(['bg-color' => self::$style['box_highlight_font_color']])
      ])
    ])
  ]);

  $this->paragraph = tag([
      '> h2' => style([
        'margin-bottom' => '0.5em',
        'text-decoration' => 'underline',
        'font-family' => "'VT323', monospace",
        'font-weight' => 'unset'
      ]),
      ' a' => style([
        'color' => self::$style['highlight_font_color'],
        'text_decoration' => 'none',
        ':hover' => style(['text_decoration' => 'underline'])
      ]),
      '> pre' => style([
        'color' => 'white',
        'font-family' => 'inherit',
        'border' => '1px solid',
        'padding' => '1em',
        'overflow' => 'hidden',
        'font-size' => '0.8em',
        'white-space' => 'pre-wrap'
      ]),
      ' code' => style(['color' => 'white', 'font-family' => 'inherit']),
      '> pre a' => style(['color' => 'inherit', 'text-decoration' => 'none'])
    ])
  ]);

}


function head() {

  parent::head();
?>
<style>
h1, h2, h3, h4, h5, h6 {
  font-family : <?=self::$style['font_emph']?>;
}
button { cursor: pointer; }

p { line-height: 1.5em; }
a { cursor: pointer; text-decoration: none; color: <?=}
a:hover { text-decoration: underline; }

hr {
  border: 0;
  border-bottom: 1px dashed;
  margin: 3em 0;
}
<?php

  style('.container-padding' [
    'padding' => '1em'
  ]);

  style('.font-normal', [
    'font-family' => self::$style['font_normal']
  ]);

  style('.font-emph', [
    'font-family' => self::$style['font_emph']
  ]);

  style('.box', [
    'background-color' => self::$style['box_background_color']
  ]);

  style('.box-hover', [
    ':hover' => [
      'color' => self::$style['background-color'],
      'background-color' => self::$style['highlight_font_color']
    
  ]);

  style('.button', [
    'display' => 'block',
    'font-weight' => 'bold',
    'background-color' => self::$style['box_background_color'],
    'color' => self::$style['background_color'],
    'text-decoration' => 'none',
    'cursor' => 'pointer',
    'text-align' => 'center',
    ':hover' => ['background-color' => self::$style['highlight_font_color']],
    'padding' => '0.5em 0.7em'
  ]);
}

function body($content) {
  $this->__header();
  ($this->nav)();
  $this->__main($content);
  $this->__footer();
}

function header($content = '') {
  t__(['class' => ['section-container', 'bg-box']]);
  t__('header', ['class' => ['layout-row'], 'style' => ['position' => 'relative']]);
  
    tag('a', ['class' => ['font-emph'], 'href' => '/', 'style')('Edwin Rodríguez');

  __t();
  __t();
}

function footer($content) {
  t__(['class' => ['section-container']]);
  t__(['class' => ['container-padding']]);
    tag('hr')();
    echo $content;
  __t();
  __t();
}

}


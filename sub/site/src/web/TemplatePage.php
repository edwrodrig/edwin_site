<?php
namespace blog\web;

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
  'box_highlight_font_color' => 'yellow'
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
    ':hover' => style(['bg-color' => self::$style['box_font_color'], 'color' => self::$style['box_background_color']]),
  ]);
  $this->nav->mobile->item->set([$item_style]);
  $this->nav->desktop->item->set([$item_style]);
  $this->font_files = ['https://fonts.googleapis.com/css?family=Cutive+Mono|VT323'];
  $this->body->set([
    style_def([
      'font-family' => "'Cutive Mono', monospace",
      'bg-color' => self::$style['background_color'],
      'color' => self::$style['font_color'],
      'font-size' => '1.2em'
    ])
  ]);

  $this->style_container_padding = style_def(['padding' => '0.5em']);

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
    style_def([
      '> p' => style([
        'text-align' => 'justify',
        'line-height' => '1.42857143em',
        'margin-bottom' => '1em'
      ]),
      '> h1' => style([
        'margin' => '1em 0',
        'font-family' => "'VT323', monospace",
        'font-weight' => 'unset'
      ]),
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

  $this->button = tag('a', [
    style_def([
      'display' => 'block',
      'font-weight' => 'bold',
      'background-color' => self::$style['box_background_color'],
      'color' => self::$style['background_color'],
      'text-decoration' => 'none',
      'cursor' => 'pointer',
      'text-align' => 'center',
      ':hover' => style(['background-color' => self::$style['highlight_font_color']]),
      'padding' => '0.5em 0.7em'
    ])
  ]);

  $this->title = tag('h1', [
    style_def([
      'font-family' => "'VT323', monospace",
      'margin-bottom' => '1em',
      'font-weight' => 'unset'
    ])
  ]);

  $this->separator = tag('hr', [
    style_def([
      'border' => 0,
      'border-bottom' => '1px dashed',
      'margin' => '3em 0'
    ])
  ]);
}

function head($content) {
  echo $content;
}

function body($content) {
  $this->__header();
  ($this->nav)();
  $this->__main($content);
  $this->__footer();
}

function header($content) {
  container__([style(['bg-color' => self::$style['box_background_color']])])();
    t__('header', [style(['layout' => 'row', 'position' => 'relative'])]);
      echo $content;
    __t();
  __container();
}

function footer($content) {
  container__()([$this->style_container_padding]);
    tag($this->separator)();
    echo $content;
  __container();
}

}


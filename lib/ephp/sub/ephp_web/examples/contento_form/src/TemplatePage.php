<?php

class TemplatePage extends \ephp\web\TemplatePage {

public $json;
public $set_value;

function __construct($json, $set_value = 'hola') {
  $this->json = $json;
  $this->set_value = $set_value;
  parent::__construct();

  $this->style = style_def([
    ' *' => style([
      'box-sizing' => 'border-box'
    ]),
    ' textarea' => style([
      'resize' => 'vertical',
      'width' => '100%',
      'height' => '20em'
    ])
  ]);

}

function head($content = '') {
  \ephp\web\WidgetTableListJs::html_include();
  \ephp\web\contento\InputString::html_include();
  \ephp\web\contento\InputDate::html_include();
  \ephp\web\Fa::html_include();

  style('.contento-input', [
    '> label' => style([
        'display' => 'block',
        'padding-top' => '10px',
        'padding-bottom' => '10px'
    ]),
    'padding-bottom' => '30px'
  ])->print();

  style('.contento-input-object', [
    'padding' => 0,
    'border' => 0,
    'margin' => 0,
    'margin-left' => '50px'
  ])->print();

  style('.contento-input-list', [
    ' > table' => style([
      'border-collapse' => 'collapse',
      'border-spacing' => '0'      
    ]),
    ' > table > tbody > tr:nth-of-type(odd)' => style([
      'background-color' => '#f9f9f9'
    ]),
    ' > table > thead > tr > th' => style([
      'text-align' => 'left',
      'padding' => '8px',
      'line-height' => '1.42857143',
      'vertical-align' => 'top',
      'border-top' => '1px solid #dddddd'
    ]),
    ' > table > tbody > tr > th' => style([
      'text-align' => 'left',
      'padding' => '8px',
      'line-height' => '1.42857143',
      'vertical-align' => 'top',
      'border-top' => '1px solid #dddddd'
    ]),
    ' > table > tbody > tr > td' => style([
      'padding' => '8px',
      'line-height' => '1.42857143',
      'vertical-align' => 'top',
      'border-top' => '1px solid #dddddd'
    ])
  ])->print();

  echo $content;
}


function body($content) {
  $type = \contento\Type::create(json_decode($this->json, true));

  $input = \ephp\web\contento\Input::create($type);
  t__('fieldset', [$this->style]);
  $input('#');
  __t();
  $input->debug_buttons($this->set_value);
}

}

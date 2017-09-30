<?php

namespace theme\contento;

class TemplateCommon {

static function style_table() {
  if ( dg() ) :
  t__('style');
 
  style('.contento-table', [
    'box-sizing' => 'border-box',
    'width' => '100%',
    'border-collapse' => 'collapse',
    'border-spacing' => '0',
    ' > tbody > tr:nth-of-type(odd)' => [
      'background-color' => '#f9f9f9'
    ],
    ' > thead > tr > th' => [
      'text-align' => 'left',
      'padding' => '8px',
      'line-height' => '1.42857143',
      'vertical-align' => 'top',
      'border-top' => '1px solid #dddddd'
    ],
    ' > tbody > tr > th' => [
      'text-align' => 'left',
      'padding' => '8px',
      'line-height' => '1.42857143',
      'vertical-align' => 'top',
      'border-top' => '1px solid #dddddd'
    ],
    ' > tbody > tr > td' => [
      'padding' => '8px',
      'line-height' => '1.42857143',
      'vertical-align' => 'top',
      'border-top' => '1px solid #dddddd'
    ]
  ]);

  __t();
  endif;
}

static function style_items() {
  if ( dg() ) :

  t__('style');

  style('.contento-input', [
    'box-sizing' => 'border-box',
    '> label' => [
        'display' => 'block',
        'padding-top' => '10px',
        'padding-bottom' => '10px'
    ],
    '> div > input[type=text]' => [
      'width' => '100%',
      'box-sizing' => 'border-box'
    ],
    '> div > textarea' => [
      'width' => '100%',
      'box-sizing' => '100%'
    ],
    'padding-bottom' => '30px'
  ]);

  style('.contento-input-object', [
    'padding' => 0,
    'border' => 0,
    'margin' => 0,
    'margin-left' => '50px'
  ]);

  __t();
  self::style_table();
  endif;
}

}

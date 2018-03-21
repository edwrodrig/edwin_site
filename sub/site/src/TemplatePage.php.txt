<?php

namespace edwin\web;

class TemplatePage extends \theme\console_blog\TemplatePage {


function fragment_post_box($data) {
  t__('a', [
    'href' => $data['link'],
    'class' => ['box-hover', [
      'overflow' => 'hidden',
      'text-decoration' => 'none',
    ]]
  ]);
    tag('h2', ['style' => ['margin-bottom' => '0.2em']])(tr($data['title']));
    t__('time', ['class' => ['style' => ['font-style' => 'italic']]]);
      \ephp\web\Fa::inline('clock-o'); echo \ephp\Format::date($data['date']);
    __t();
  __t();
}

function fragment_project_box($data) {
  t__('a', [
    'href' => $data['url'],
    'class' => ['box-hover', [
      'overflow' => 'hidden',
      'text-decoration' => 'none',
      'color' => 'inherit',
    ]]
  ]);
  t__(['class' => ['layout-row', 'grid-padding', [
    '@media (max-width : 500px)' => ['flex-direction' => 'column'],
    '> *' => ['overflow' => 'hidden']
  ]]]);
    
    tag([
      'class' => [[
        'background-size' => 'cover',
        'background-position' => 'center',
        'background-repeat' => 'no-repeat',
        'width' => '100px',
        'height' => '100px'
      ]],
      'style' => ['bg-img' => $data['image']]
    ])();
    t__();
      tag('h2', ['style' => ['margin-top' => '0.2em']])($data['name']);
      tag('p', ['class' => ['text-justify']])($data['description']);
    __t();
  __t();
  __t();
}


}


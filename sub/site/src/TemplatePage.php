<?php

namespace edwin\web;

class TemplatePage extends \theme\console_blog\TemplatePage {

function head() {
  parent::head();
  \ephp\web\Fa::html_include();
}

function fragment_nav() {
  $links = [
    ['href' => url('/posts.html'), 'content' => tr(['es' => 'Artículos', 'en' => 'Posts'])],
    ['href' => url('/projects.html'), 'content' => tr(['es' => 'Proyectos', 'en' => 'Projects'])]
  ];

  foreach ( $links as $link ) {
    $this->fragment_nav_item($link);
  }
}

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


function fragment_social_buttons() {
  $social_buttons = [
    ['http://www.github.com/edwrodrig', 'github'],
    ['http://www.linkedin.com/pub/edwin-iv%C3%A1n-rodr%C3%ADguez-le%C3%B3n/35/241/848', 'linkedin'],
    ['http://play.google.com/store/apps/developer?id=edwrodrig', 'android'],
    ['http://edwrodrig.deviantart.com/', 'deviantart'],
    ['https://twitter.com/edwrodrig', 'twitter'],
    ['http://www.pinterest.com/edwrodrig', 'pinterest'],
    ['http://www.codepen.io/edwrodrig', 'codepen'],
    ['https://www.youtube.com/user/edwrodrig1', 'youtube-play']
  ];

  t__(['class' => [ 'layout-row', 'layout-center', 'grid-padding', 'layout-wrap', 'bigger-font']]);
  foreach ( $social_buttons as $button ) {
    t__('a', ['href' => $button[0]]);
      \ephp\web\Fa::icon($button[1]);
    __t();
  }
  __t();
}

function footer($content) {
  $this->fragment_social_buttons();
  tag(['class' => ['text-center'], 'style' => ['margin-top' => '1em']])(sprintf('%s - Edwin Rodríguez',  date("Y")));
}

}


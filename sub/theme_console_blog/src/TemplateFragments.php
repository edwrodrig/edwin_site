<?php
namespace theme\console_blog;

trait TemplateFragments {

function fragment_project_box($project) {
  t__('a', [
    'class' => [
      'layout-row',
      'grid-padding',
      'box-hover',
      [
        'overflow' => 'hidden',
        'text-decoration' => 'none',
        'color' => 'inherit',
        '@media (max-width : 500px)' => ['layout' => 'column'],
        '> *' => ['overflow' => 'hidden'],
      ]
    ],
    'href' => $project['url']
  ]);
     t__([
      'class' => [[
        'background-size' => 'cover',
        'background-position' => 'center',
        'background-repeat' => 'no-repeat',
        'width' => '100px',
        'height' => '100px',
        'min-width' => '100px'
      ]],
      'style' => ['bg-img' => $project['image']]
    ])();
    t__();
      tag('h1')($project['name']);
      tag(['style' => ['text-align' => 'justify']])($project['description']);
    __t();

  __t();
}

function fragment_post_box($post) {
  t__('a', ['href' => $post['link'], 'title' => $post['title']],     style_def([
      'display' => 'block',
      'text-decoration' => 'none',
      'color' => 'inherit',
      'margin-bottom' => '1.5em',
      ':hover' => ['color' => TemplatePage::$style['highlight_font_color']]
    ]));
    t__('h2')($post['title']);
    tag('time', ['style' => ['display' => 'block']])(\ephp\Format::date($post['date']));
  __t();
}

}


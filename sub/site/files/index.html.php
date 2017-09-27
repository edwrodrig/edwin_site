<?php


(new class extends \edwin\web\TemplatePage {

function section_posts() {
  t__();
    tag('h1')(tr(['en' => 'Posts', 'es' => 'Artículos']));
    t__(['class' => ['layout-column', 'grid-padding']]);
    $index = 0;
    foreach ( \data()['posts'] as $post ) {
      if ( ++$index > 4 ) break;
      t__();
        $this->fragment_post_box($post);
      __t();
    }
    t__(['class' => ['layout-row', ['justify-content' => 'flex-end']]]);
      tag('a', ['class' => 'button', 'href' => url('/posts.html')])(tr(['en' => 'More posts', 'es' => 'Más artículos']));
    __t();
    __t();
  __t();
}

function section_projects() {
  t__();
    tag('h1')(tr(['en' => 'Featured projects', 'es' => 'Proyectos']));
    t__(['class' => ['layout-column', 'grid-padding']]);
    $index = 0;
    foreach ( \data()['projects'] as $pro ) {
      if ( $index++ > 2 ) break;
      t__();
        $this->fragment_project_box($pro);
      __t();
    }
    t__(['class' => ['layout-row',['justify-content' => 'flex-end']]]);
        tag('a', ['class' => 'button', 'href' => url('/projects.html')])(tr(['en' => 'More projects', 'es' => 'Más proyectos']));
    __t();
    __t();
  __t();

}

function section_photo() {
  t__(['class' => ['layout-row', 'layout-center'], 'style' => ['overflow-x' => 'hidden', 'margin-bottom' => '1.5em']]);
    tag('pre', [
      'style' => [
        'font-family' => 'inherit',
        'color' => 'white',
        'font-size' => '0.4em',
        'line-height' => '0.9em'
      ]
    ])(\data()['ascii_photos']['edwin']['data']);;
  __t();
}

function body($content = '') {
  t__(['class' => ['section-container']]);
  t__(['class' => ['container-padding']]);
    $this->section_photo();
    $this->fragment_social_buttons();
    $this->section_posts();
    tag('hr')();
    $this->section_projects();
  __t();
  __t();
}

})->print();


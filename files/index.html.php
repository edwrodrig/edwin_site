<?php


(new class extends MyTemplatePage {

function __construct() {
  parent::__construct();
}

function section_posts() {
  t__();
    tag($this->title)(tr(['en' => 'Posts', 'es' => 'Artículos']));
    foreach ( \Data::forPost() as $index => $post ) {
      if ( $index > 4 ) break;
      (new \blog\web\PostBox)($post);
    }
    t__([style(['layout' => 'row-right'])]);
      tag($this->button, ['href' => url('/posts.html')])(tr(['en' => 'More posts', 'es' => 'Más artículos']));
    __t();
  __t();
}

function section_projects() {
  t__();
    tag($this->title)(tr(['en' => 'Featured projects', 'es' => 'Proyectos']));
    foreach ( \Data::forProject() as $index => $pro ) {
      if ( $index > 2 ) break;
      (new \blog\web\ProjectBox)($pro);
    }
    t__([style(['layout' => 'row-right'])]);
      tag($this->button, ['href' => url('/projects.html')])(tr(['en' => 'More projects', 'es' => 'Más proyectos']));
    __t();
  __t();

}

function section_photo() {
  t__([style(['display' => 'flex', 'overflow-x' => 'hidden', 'justify-content' => 'center'])]);
    tag('pre', [
      style([
        'font-family' => 'inherit',
        'color' => 'white',
        'font-size' => '0.4em',
        'line-height' => '0.9em'
      ])
    ])(file_get_contents('data/photo.txt'));
  __t();
}

function main($content = '') {
container__()([$this->style_container_padding]);
  $this->section_photo();
  $this->section_posts();
  tag($this->separator)();
  $this->section_projects();
__container();
}

})();


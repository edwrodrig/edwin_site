<?php

namespace theme\contento;

class TemplateMain extends TemplatePage {

public $collections;

function __construct($collections) {
  parent::__construct();
  $this->body->set([
    'style' => [
      '@media ( min-height : 600px )' => [
        'box-sizing' => 'border-box',
        'height' => '100vh'
      ]
    ]
  ]);
  $this->collections = $collections;
}

function head() {
  parent::head();
  (new \ephp\web\usac\Client)();
  (new \theme\contento\Client)();
  \ephp\web\Iframe::js_functions_parent();
  
}

function fragment_collection_link($collection) {
  tag('a', [
    'href' => '/collection/' . $collection['name'] . '/list.html',
    'target' => 'collection_view'
  ])(ucfirst($collection['label']));
}

function fragment_collection_bar() {
  $collections = [];  

  foreach( $this->collections as $collection ) {
    $collection = $collection['data'];
    $collections[] = ['name' => $collection['name'], 'label' => ucfirst(tr($collection['label']))];
  }
  $collections[] = ['name' => 'image', 'label' => ucfirst(tr(['es' => 'Imágenes', 'en' => 'Images']))];

  usort($collections, function($a, $b) { return $a['label'] <=> $b['label']; });


  t__(['class' => [
    'layout-column',
    [
      '> *' => [
        'box-sizing' => 'border-box',
        'padding' => '0.3em 0.5em'
      ]
    ]
  ]]);
    foreach( $collections as $collection ) {
      $this->fragment_collection_link($collection);
    }
  __t();
}


function header($content = '') {
  t__(['class' => [
    'layout-row',
    [
      '> *' => [
        'box-sizing' => 'border-box',
        'padding' => '0.5em 0.5em'
      ],
      '> a' => [
        'color' => '#fff'
      ]
    ]
  ]]);
    tag()(tr(['es' => 'Colecciones', 'en' => 'Collections']));
    tag('a', ['onclick' => 'make_website()'])(tr(['es' => 'Actualizar página', 'en' => 'Update page']));
  __t();
}

function body($content = '') {
  t__(['class' => ['layout-row', 'grid-padding', ['width' => '100%', 'height' => '100%']]]);
      $this->fragment_collection_bar();
    tag('iframe', ['name' => 'collection_view', 'style' => ['border' => 0, 'flex-grow' => 1]])();
  __t();
}

function js_functions() {
  parent::js_functions();
  (new \theme\contento\Client)();
?>
<script>
function make_website() {
  <?=\theme\app\TemplateModalAction::launch_in_iframe(
    tr(['es' => 'Enviando...', 'en' => 'Sending...']),
    tr(['es' => 'Actualizando página', 'en' => 'Updating page']),
    function() {
      tag('p')(tr([
               'es' => 'Contento está actualizando la página, estará lista dentro en minutos',
               'en' => 'Contento is updating the page, it will be ready in minutes'
              ]));
    }
  )?>;

  CONTENTO_CLIENT.request({
      action : 'make_website',
      session : EPHP_USAC_CLIENT.get_session()
    },
    {
      success : function(data) {
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'success');
      },
      error: function(data) {
        console.log(data);
        IFRAME_MANAGER_PARENT.signal('slot_set_placeholder', data.message);
        IFRAME_MANAGER_PARENT.signal('slot_change_page', 'error');
      }
    }
  );
    
}
</script>
<?php
}


}

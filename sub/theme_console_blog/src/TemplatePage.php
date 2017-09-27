<?php
namespace theme\console_blog;

class TemplatePage extends \ephp\web\TemplatePage {

use TemplateCommon;

static public $base_metadata = [];

function __construct($metadata = []) {
  parent::__construct(array_replace_recursive(self::$base_metadata, $metadata));
  $this->font_files = ['https://fonts.googleapis.com/css?family=Cutive+Mono|VT323'];

  $this->nav_min_width = '600px';
}


function head() {
  parent::head();
  $this->styles();
}

function body($content = '') {
  $this->bottom_up_call('header');
  echo $content;
  $this->bottom_up_call('footer');
}

function header($content = '') {
  t__(['class' => ['section-container', 'bg-box']]);
  t__([
    'style' => [
      'display' => 'flex',
      'flex-direction' => 'row',
      "@media( max-width : $this->nav_min_width )" => [
        'flex-direction' => 'column'
      ]
    ]
  ]);
    t__('header', ['class' => ['layout-row', 'layout-align-end'], 'style' => ['flex-grow' => 1, 'position' => 'relative', '> *' => ['padding' => '1em']]]);
      t__();
        tag('a', ['class' => ['font-emph'], 'style' => ['font-weight' => 'bold', 'text-decoration' => 'none', 'font-size' => '2em'], 'href' => '/'])('Edwin Rodríguez');
      __t();
      tag(['style' => ['flex-grow' => 1]])();
      t__(['style' => ['align-self' => 'flex-end', 'display' => 'none', "@media ( max-width : $this->nav_min_width)" => ['display' => 'block']]]);
        t__('button', [
            'type' => 'button',
            'onclick' => 'toggle_nav()',
            'style' => [
              'padding' => '0.05em 0.2em',
              'font-size' => '32px',
              'border' => '1px solid transparent',
              'border-radius' => '0.2em',
              'background-color' => 'transparent',
              'border-color' => 'white',
              'color' => 'white',
              ':hover' => [
                'background-color' => 'rgba(255,255,255, 0.2)'
              ]
            ]
        ]);
          \ephp\web\Fa::icon('bars');
        __t();
      __t();
    __t();
    $this->nav = t__('#', 'nav', [
      'class' => [[
        'overflow-x' => 'hidden',
        'display' => 'flex',
        'align-items' => 'flex-end',
        "@media (max-width: $this->nav_min_width)" => [
          'display' => 'none',
          'flex-direction' => 'column',
          '[nav-show]' => [
            'display' => 'flex'
          ]
        ]
      ]]
    ]);
      echo $content;
      $this->fragment_nav();
    __t();
  __t();
  __t();
}

function fragment_nav_item($item) {
  tag('a', [
    'title' => $item['title'] ?? $item['content'] ?? null,
    'href' => $item['href'],
    'class' => [
      'bg-hover',
      'container-padding',
      [
        'text-decoration' => 'none',
        'display' => 'block',
        'white-space' => 'nowrap',
      ]
    ]
  ])($item['content'] ?? '');
      
}

function footer($content) {
  t__(['class' => ['section-container']]);
  t__(['class' => ['container-padding']]);
    tag('hr')();
    echo $content;
  __t();
  __t();
}

function js_functions() {
  parent::js_functions();
?>
<script>
function toggle_nav() {
  var elem = <?=js($this->nav)?>;
  if ( elem.hasAttribute('nav-show') )
    elem.removeAttribute('nav-show');
  else
    elem.setAttribute('nav-show', true);
}  

</script>
<?php
}


}


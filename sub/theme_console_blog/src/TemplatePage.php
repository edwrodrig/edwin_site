<?php
namespace theme\console_blog;

class TemplatePage extends \ephp\web\TemplatePage {

use TemplateCommon;

static public $base_metadata = [];

function __construct($metadata = []) {
  parent::__construct(array_replace_recursive(self::$base_metadata, $metadata));
/*
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
    ':hover' => ['bg-color' => self::$style['box_font_color'], 'color' => self::$style['box_background_color']]
  ]);
  $this->nav->mobile->item->set([$item_style]);
  $this->nav->desktop->item->set([$item_style]);
*/
  $this->font_files = ['https://fonts.googleapis.com/css?family=Cutive+Mono|VT323'];
/*
  $this->body->set(['style' => [[
    'font-family' => self::$style['font_normal'],
    'background-color' => self::$style['background_color'],
    'color' => self::$style['font_color'],
  ]);

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
*/

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
    t__('header', ['class' => ['layout-row'], 'style' => ['position' => 'relative']]);
      tag('a', ['class' => ['font-emph'], 'href' => '/'])('Edwin Rodríguez');
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
    __t();

    $this->fragment_nav();
  __t();
  __t();
}

function fragment_nav_item($item) {
  tag('a', [
    'title' => $item['title'] ?? $item['content'] ?? null,
    'href' => $item['href'],
    'class' => [
      'bg-hover',
      [
        'display' => 'block',
        'padding' => '0.5em 0.7em',
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


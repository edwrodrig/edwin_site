<?php
namespace ephp\web;

abstract class TemplatePage extends Template {

public $metadata;
public $html;
public $body;
public $font_files = [];
public $default_padding = '1em';

function __construct($metadata = []) {
  $this->metadata = $metadata;
  $this->html = tag('html');
  $this->body = tag('body', ['style' => ['padding' => '0', 'margin' => '0']]);
}

function print() {
  echo '<!DOCTYPE html>';
  $this->html->open();
  t__('head');
  $this->head();
  __t();
  $this->bottom_up_call('body');
  $this->html->close();
}

function set_fullscreen() {
  $this->html->set(['style' => ['width' => '100%', 'height' => '100%']]);
  $this->body->set(['style' => ['width' => '100%', 'height' => '100%', 'box-sizing' => 'border-box', 'position' => 'relative']]);
}

private function fonts() {
  foreach ( $this->font_files as $url ) {
    printf('<link href="%s" rel="stylesheet" type="text/css">', $url);
  }
}

private function google_analytics() {
  if ( !isset($this->metadata['tracking_id']) ) return;
  $tracking_id = $this->metadata['tracking_id'];
?>
<script>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?=$tracking_id?>']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<?php
}

function style_layout() {
  style('.layout-row', [
    'display' => 'flex'
  ]);

  style('.layout-space-between', [
    'justify-content' => 'space-between'
  ]);

  style('.layout-wrap', [
    'flex-wrap' => 'wrap'
  ]);

  style('.layout-items-start', [
    'align-items' => 'flex-start'
  ]);

  style('.layout-items-end' , [
    'align-items' => 'flex-end'
  ]);

  style('.layout-center', [
    'justify-content' => 'center'
  ]);

  style('.layout-column', [
    'display' => 'flex',
    'flex-direction' => 'column'
  ]);

  style('.text-center', [
    'text-align' => 'center'
  ]);
  
  style('text-justify', [
    'text-align' => 'justify'
  ]);

  style('.grid-padding', [
    'margin-top' => "-$this->default_padding",
    'margin-left' => "-$this->default_padding",
    ' > *' => ['margin-top' => $this->default_padding, 'margin-left' => $this->default_padding]
  ]);

  style('.container-padding', ['box-sizing' => 'border-box', 'padding' => $this->default_padding]);

  style('.span-padding', ['box-sizing' => 'border-box', 'padding' => '0.5em 0.7em']);

  style('.layout-grid-3-1', [
    '> *' => [
      'box-sizing' => 'border-box',
      'width' => "calc(33% - $this->default_padding)",
      '@media ( max-width : 850px )' => [
        'width' => '100%'
      ]
    ]
  ]);

  style('.layout-grid-3-2-1', [
    '> *' => [
      'box-sizing' => 'border-box',
      'width' => "calc(33% - $this->default_padding)",
      '@media ( max-width : 900px )' => [
        'width' => "calc(50% - $this->default_padding)"
      ],
      '@media ( max-width : 600px )' => [
        'width' => '100%'
      ]
    ]
  ]);

  style('.layout-grid-2-1', [
    '> *' => [
      'box-sizing' => 'border-box',
      'width' => "calc(50% - $this->default_padding)",
      '@media ( max-width : 700px )' => [
        'width' => '100%'
      ]
    ]
  ]);

  style('.layout-grid-4-2-1', [
    '> *' => [
      'box-sizing' => 'border-box',
      'width' => "calc(25% - $this->default_padding)",
      '@media ( max-width : 1100px )' => [
        'width' => "calc(50% - $this->default_padding)"
      ],
      '@media ( max-width : 500px )' => [
        'width' => '100%'
      ]
    ]
  ]);

  style('.layout-grid-4-3-2-1', [
    '> *' => [
      'box-sizing' => 'border-box',
      'width' => "calc(25% - $this->default_padding)",
      '@media ( max-width : 1100px )' => [
        'width' => "calc(33% - $this->default_padding)"
      ],
      '@media ( max-width : 850px )' => [
        'width' => "calc(50% - $this->default_padding)"
      ],
      '@media ( max-width : 500px )' => [
        'width' => '100%'
      ]
    ]
  ]);


  style('.responsive', [
     'position' => 'relative',
     'height' => 0,
     '> *' => [
       'position' => 'absolute',
       'bottom' => 0,
       'left' => 0,
       'width' => '100%',
       'height' => '100%',
       'border' => 0
     ]
  ]);

  style('.responsive-square', [
    'width' => '100%',
    'padding-bottom' => '100%'
  ]);

  style('.responsive-4-3', [
    'width' => '100%',
    'padding-bottom' => '75%'
  ]);

  style('.responsive-16-9', [
    'width' => '100%',
    'padding-bottom' => '56.25%'
  ]);

  style('.bigger-font', [
    'font-size' => '1.5em'
  ]);

}

protected function base_style() {
?>
<style>
html { box-sizing: border-box; }
*, *:before, *:after { box-sizing:inherit; }
a { color:inherit;text-decoration:none;cursor:pointer; }
button { cursor:pointer; }
ul { list-style-type: none; padding:0; margin:0}
h1, h2, h3, h4, p { margin:0; }
</style>
<?php
}

function js_functions() {
}

function js_script() {
  $this->google_analytics();
}

function body($content) {
  $this->body->open();
  echo $content;
  $this->js_functions();
  $this->js_script();
  $this->body->close();
}

function head() {
  (new \ephp\web\Meta($this->metadata))();
  $this->fonts();
?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php
}

function launch_in_iframe(...$args) {
  return \ephp\web\Iframe::open(function() use($args) {
    $modal = new static(...$args);
    $modal->print();
  });
}

}


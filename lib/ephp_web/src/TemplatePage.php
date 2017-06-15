<?php
namespace ephp\web;

class TemplatePage extends Template {

public $metadata;
public $html;
public $body;
public $font_files = [];

function __construct($metadata = []) {
  $this->metadata = $metadata;
  $this->html = tag('html');
  $this->body = tag('body', [style(['padding' => '0', 'margin' => '0'])]);
}

function __invoke($content = '', $head = '') {
  echo '<!DOCTYPE html>';
  $this->html->open();
  $this->tag_html();
  $this->__head($head);
  $this->__body($content);
  $this->html->close();
  echo '</html>';
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

function body($content) {
  t__($this->body);
  echo $content;
  $this->google_analytics();
  __t();
}

function head($content) {
  echo '<head>';
  (new \ephp\web\Meta($this->metadata))();
  $this->fonts();
  echo $content;
?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<?php
}

}


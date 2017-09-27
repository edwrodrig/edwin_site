<?php

namespace ephp\web;

class Fa {

static function html_include() {
if ( dg() ) :
  \ephp\web\ProcFile::register(__DIR__ . '/../files', 'fa');
?>
<link rel="stylesheet" type="text/css" href='/fa/css/font-awesome.min.css'/>
<?php
endif;
}

static function icon($type, ...$args) {
  $tag = tag('i', [
    'class' => ['fa', "fa-" . $type ,[ 'aria-hidden' => true]]],
    ['class' => ($type == 'spinner' ? ['fa-spin'] : [])]);
  $tag->set(...$args);
  return $tag();
  
}

static function inline($type, ...$args) {
  return \ephp\web\Fa::icon($type, ['class' => ['fa-fw', ['margin-right' => '0.5em']]], ...$args);
}

}


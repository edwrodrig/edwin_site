<?php
namespace ephp\web;

abstract class TemplatePageStacked extends TemplatePage {

public $pages;

function __construct() {
  parent::__construct();
  $this->set_fullscreen();
  $this->pages = tag('#', [ 'style' => [
    'position' => 'relative',
    'width' => '100%',
    'height' => '100%',
    '> *' => [
      'position' => 'absolute',
      'width' => '100%',
      'height' => '100%',
      'opacity' => '0',
      'transition' => 'opacity 0.5s',
      'visibility' => 'hidden'
    ],
    '> [name=first]' => [
      'visibility' => 'visible',
      'opacity' => 1
    ]
  ]]);

}

function js_functions() {
  parent::js_functions();
?>
<script>
function change_page(elem, name) {
  var elems = elem.children;
  if ( elem.t != undefined ) {
    clearTimeout(elem.t);
    elem.t = null;
  }
  

  var elems_to_hide = [];
  for ( var i = 0; i < elems.length ; i ++) {
    var e = elems[i];
    if ( e.getAttribute('name') == name ) {
      e.style.visibility = 'visible';
      e.style.opacity = 1;
    } else {
      elems_to_hide.push(e);
      e.style.opacity = 0;
    }
  }

  elem.t = setTimeout(function() {
    for ( var i = 0 ; i < elems_to_hide.length ; i++ ) {
      elems_to_hide[i].style.visibility = 'hidden';
    }
  }, 500);
}

function slot_change_page(name) {
  change_page(<?=js($this->pages)?>, name);
}
</script>
<?php
}

function body($content = '') {
  $this->pages->open();
  echo $content;
  $this->pages->close();
}

function js_script() {
  parent::js_script();
?>
<script>
window.addEventListener('load', function() {
  if ( typeof window['init'] === 'function' ) init();
});
</script>
<?php
}


}


<?php
namespace ephp\web;

class ShowCase extends Template {

public $container;
public $internal_container;
public $time = 8000;
public $arrow;

protected $pages = [];

function __construct() {
  $this->container = tag(['style' => ['overflow' => 'hidden', 'position' => 'relative']]);
  $this->internal_container = tag('#', ['style' => ['left' => '0'], 'class' => [['position' => 'absolute', 'width' => '100%', 'height' => '100%', 'min-width' => '100%', 'trans' => ['left' => '0.5s'], '> *' => ['position' => 'absolute', 'width' => '100%', 'height' => '100%', 'min-width' => '100%']]]]);

  $this->arrow = tag(['class' => [['position' => 'absolute', 'top' => '50%', 'padding' => '0.6em', 'font-size' => '1.5em']]]);

}

function add_page($page) {
  $this->pages[] = $page;
}

function print() {
  $this->container->open();
  $this->internal_container->open();
  
  foreach ( $this->pages as $index => $page ) {
    t__(['style' => ['left' => sprintf('%s%%', $index * 100)]]);
      echo Util::ob_safe($page);
    __t();
  }

  $this->internal_container->close();

  $arrow = clone $this->arrow;
  $arrow->set(['style' => ['left' => '0'], 'onclick' => 'showcase_advance(' . js($this->internal_container). ', -1)' ]);
  $arrow->open();
    Fa::icon('chevron-circle-left');
  $arrow->close();


  $arrow = clone $this->arrow;
  $arrow->set(['style' => ['right' => '0'], 'onclick' => 'showcase_advance(' . js($this->internal_container) . ', 1)' ]);
  $arrow->open();
    Fa::icon('chevron-circle-right');
  $arrow->close();

  $this->container->close();
  $this->js_functions();
}

function js_functions() {
if ( dg() ) : ?>
<script>
function showcase_advance(e, inc, clear=true) {
  if ( clear === true ) clearInterval(e.timer);
  if ( e.i === undefined ) e.i = 0;
  e.i = (e.i + inc);
  var length = 0;
  for ( var i = 0 ; i < e.children.length ; i++ )
    if ( e.children[i].tagName.toLowerCase() == 'div' )
      length++;
  if ( e.i < 0 ) e.i = length - 1;
  e.i %= length;
  e.style.left = (e.i * - 100).toString() + '%';
}
</script>
<?php
endif;
?>
<script>
<?=js($this->internal_container)?>.timer = setInterval(function() { showcase_advance(<?=js($this->internal_container)?>, 1, false); }, <?=$this->time?>);
</script>
<?php
}

}



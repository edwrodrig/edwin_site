<?php
namespace ephp\web;

class Overlay extends Template {

public $container;
public $inside_container;

function __construct(...$args) {
  $this->container = tag('#', [style_def(['display' => 'none', 'position' => 'fixed', 'top' => 0, 'left' => 0, 'width' => '100%', 'height' => '100%', 'opacity' => 0, 'bg-color' => 'rgba(0,0,0,0.5)', 'z-index' => 1000, 'trans' => ['opacity' => '0.5s']])]);
  $this->inside_container = tag([style(['width' => '100%', 'height' => '100%'])], ...$args);

}

function body($content = '') {
  echo $content; 
}

function __invoke($content = '') {
  $this->js();
  $this->container->open();
  $this->inside_container->open();
  $this->__body($content);
  $this->inside_container->close();
  $this->container->close();
  return $this;
}

function js_open() { 
  $id = $this->container->id;
  return "overlay_fade_in(document.getElementById('$id'))";
}

function js_close() {
  $id = $this->container->id;
  return "overlay_fade_out(document.getElementById('$id'))";
}

function js() {
if ( dg() ) : ?>
<script>
function overlay_fade_in(e) {
  e.style.display = 'block';
  setTimeout(function() {
    e.style.opacity = 1;
  }, 10);
}

function overlay_fade_out(e) {
  e.style.opacity = 0;
  setTimeout(function() {
    e.style.display = 'none';  
  } , 600);
}
</script>
<?php endif;
}

}



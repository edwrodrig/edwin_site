<?php
namespace ephp\web;

class ShowCase extends Template {

public $container;
public $internal_container;
public $arrow_left;
public $arrow_right;

private $index = 0;

function __construct(...$args) {
  $this->container = tag([style(['overflow' => 'hidden', 'position' => 'relative'])],...$args);
  $this->internal_container = tag('#', [style(['left' => '0']), style_def(['position' => 'absolute', 'size' => '100%', 'trans' => ['left' => '0.5s'], '> *' => style(['position' => 'absolute', 'size' => '100%'])])]);

  $arrow_style = style_def(['position' => 'absolute', 'top' => '50%', 'padding' => '1em']);
  $this->arrow_left = tag('#',[$arrow_style, style(['left' => '0'])]);
  $this->arrow_right = tag('#', [$arrow_style, style(['right' => '0'])]);

}

function __invoke($content = null) {
  if ( $this->index === 0 ) { $this->container->open(); $this->internal_container->open(); }
  if ( is_null($content) ) {
    $this->internal_container->close();
    ($this->arrow_left)('&LT;');
    ($this->arrow_right)('&GT;');
    $this->container->close();
    $this->js();
  }
  
  t__([style(['left' => sprintf('%s%%', $this->index * 100)])]);
  if ( isset($content['image']) ) {
    t__('a', ['href' => $content['link'] ?? null, 'title' => $content['title'] ?? null]);
    self::background([style(['bg_img' => $content['image'] ?? null])])($content['content']);
    __t();
  } else echo $content['content'] ?? $content ?? '';
  __t();
  $this->index++;

  return $this;
}

public static function background(...$args) {
  return tag([style_def(['background-position' => 'center', 'background-size' => 'cover', 'size' => '100%', 'padding' => '1em', 'display' => 'flex', 'flex-direction' => 'column', 'justify-content' => 'flex-end'])], ...$args);
}

function js() {
  $id = $this->internal_container->id;
  $arrow_left = $this->arrow_left->id;
  $arrow_right = $this->arrow_right->id;
?>
<script>
<?php
if ( dg() ) : ?>
function showcase_advance(id, inc, clear=true) {
  var e = document.getElementById(id);
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
<?php endif; ?>
document.getElementById('<?=$id?>').timer = setInterval(function() { showcase_advance('<?=$id?>', 1, false)}, 4000);
document.getElementById('<?=$arrow_left?>').addEventListener('click', function() { showcase_advance('<?=$id?>', -1); });
document.getElementById('<?=$arrow_right?>').addEventListener('click', function() { showcase_advance('<?=$id?>', 1); });
</script>
<?php
}

}



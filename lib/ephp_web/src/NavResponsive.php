<?php
namespace ephp\web;

class NavResponsive extends Template {

public $desktop;
public $mobile;
public $button;

public $mode;

public $data = [];

function __construct($mode = 'below') {
  $this->mode = $mode;
  if ( $this->mode === 'below' ) {
    $this->desktop = new Nav(['hidden_small', style(['layout' => 'row'])]);
  } else {
    $this->desktop = new Nav(['hidden_small', style(['layout' => 'row'])]);
  }
  $this->mobile = new Nav('#',['visible_small_only', style(['display' => 'none']), style('.', ['layout' => 'column'])]);
  $this->button = new NavButton();
}

function __invoke($data = null) {
    if ( $this->mode === 'below' ) ($this->desktop)($data ?? $this->data ?? []);
    ($this->mobile)($data ?? $this->data ?? []);
  $this->js();
}

function header_section($data = null) {
  t__(['visible_small_only', style(['align-self' => 'flex-end'])]);
    ($this->button)();
  __t();
  if ( $this->mode === 'inside' ) ($this->desktop)($data ?? $this->data ?? []);
}

function js() {
  $button = $this->button->id;
  $nav = $this->mobile->container->id;
echo <<<EOF
<script>
document.getElementById('$button').addEventListener('click', function() {
  var e = document.getElementById('$nav');
  e.style.display = (e.style.display == 'none' ) ? '' : 'none';
}, true);
</script>
EOF;
}

}


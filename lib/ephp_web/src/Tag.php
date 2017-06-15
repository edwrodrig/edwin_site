<?php
namespace ephp\web;

class Tag {
  public $tag = 'div';
  public $id = null;
  public $attr = [];
  public $style_attr;
  public $style_id;
  public $styles = [];
  
  const SINGLE_TAGS = ['img', 'hr', 'br'];
  public static $stack = [];
  
  private static $seed_id = 0;

  function __construct(...$args) {
    $this->style_attr = new Style();
    $this->style_id = new Style();
    $this->set(...$args);
  }

  function set(...$args) {
    foreach ( $args as $arg ) {
      if ( empty($arg) ) continue;
      if ( is_string($arg) ) {
        if ( $arg[0] === '#' ) {
          $this->id = self::get_id($arg);
          ($this->style_id)('#' . $this->id);
        } else {
          $this->tag = $arg;
        }
      } else if ( $arg instanceof Tag ) {
        $this->tag = $arg->tag;
        ($this->style_attr)($arg->style_attr);
        $this->styles = $this->styles + $arg->styles;
      } else if ( is_array($arg) ) {
        foreach ( $arg as $name => $value ) {
          if ( is_null($value) ) continue;
          if ( $value instanceof Style ) {
            if ( $name === '#' ) ($this->style_id)($value);
            else if ( $value->is_class() ) $this->styles[] = $value;
            else ($this->style_attr)($value); 
          } else if ( is_string($name) ) {
            $this->attr[$name] = $value;
          } else {
            $style = Styles::__callStatic($value);
            if ( is_array($style) ) $this->set($style);
            else $this->set([$style]);
          }
        }
      }
    }
    return $this;
  }

  function open() {
    self::$stack[] = $this;
    $attr = '';
    $classes = [];

    if ( isset($this->id) ) $attr .= sprintf(' id="%s"', $this->id);
    if ( $this->style_attr->isset() ) $attr .= sprintf(' style="%s"', $this->style_attr);
    foreach ( $this->attr as $name => $value ) {
      if ( $name == 'class' ) $classes = $value;
      else $attr .= sprintf(' %s="%s"', $name, $value);
    }
    $this->style_id->print();

    foreach ( $this->styles as $s ) {
      $s->print();
      $classes[] = $s->class_str();
    }
   
    if ( !empty($classes) ) $attr .= sprintf(' class="%s"', implode(' ', $classes));
    if ( in_array($this->tag, self::SINGLE_TAGS) ) printf('<%s%s/>', $this->tag, $attr);
    else printf('<%s%s>', $this->tag, $attr); 
  }

  function close() {
    if ( !in_array($this->tag, self::SINGLE_TAGS) ) printf('</%s>', $this->tag);
    array_pop(self::$stack);
  }
 
  static function reset() {
    self::$seed_id = 0;
  }
 
  private static function get_id($arg) {
    if ( $arg === '#' ) return sprintf('t%d', self::$seed_id++);
    return substr($arg, 1);
  }

  static function spacer() {
    (new Tag([style(['flex-grow' => 1])]))();
  }

  static function br() { echo '<br/>'; }

  function __invoke($data = null) {
    $this->open();
    if ( is_string($data) ) echo $data ?? '';
    $this->close();
    return $this;
  }
}


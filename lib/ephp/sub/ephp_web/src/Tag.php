<?php
namespace ephp\web;

class Tag {
  public $tag = 'div';
  public $id = null;
  public $attr = ['class' => []];
  public $style_attr;
  public $styles = [];
  
  const SINGLE_TAGS = ['img', 'hr', 'br', 'input'];
  
  function __construct(...$args) {
    $this->style_attr = new Style();
    $this->style_id = new Style();
    $this->private_set($args, 1);
  }

  function __clone() {
    $this->style_attr = clone $this->style_attr;

    $styles = [];
    foreach ( $this->styles as $style ) {
      $styles[] = clone $style;
    }
    $this->styles = $styles;
    
    $this->id = null;
  }

  function set(...$args) {
    $this->private_set($args);
  }

  private function private_set(array $args, int $deep = 0) {
    foreach ( $args as $arg ) {
      if ( empty($arg) ) continue;
      if ( is_string($arg) ) {
        if ( $arg[0] === '#' ) {
          $this->id = self::get_id($arg);
        } else {
          $this->tag = $arg;
        }
      } else if ( $arg instanceof Tag ) {
        throw new \Exception('Cant add Tag');
        $this->tag = $arg->tag;
        ($this->style_attr)($arg->style_attr);
        $this->styles = $this->styles + $arg->styles;
        $this->attr = array_merge($this->attr, $arg->attr);
      } else if ( $arg instanceof Style ) {
        throw new \Exception('Cant add styles');
        $this->set_style($arg);
      } else if ( is_array($arg) ) {
        $this->set_array($arg, $deep);
      }
    }
    return $this;
  }

  private function set_array(array $arg, int $deep = 0) {
    foreach ( $arg as $name => $value ) {
      if ( is_null($value) ) continue;
      if ( $value instanceof Style ) {
        if ( $name === '#' ) {
          error_log('Deprecated usage of Style in tag');
          throw new \Exception('Critical invalid');
        } else if ( $name === 'style' ) {
          ($this->style_attr)($style);
        } else {
          error_log('Deprecated usage of Style in tag');
          throw new \Exception('Critical invalid');
          $this->set_style($value);
        }
      } else if ( is_string($name) ) {
        if ( $name === 'style' ) {
          ($this->style_attr)($value);
        } else if ( $name === 'class' ) {
          if ( is_string($value) ) {
            $value = [$value];
          }
          foreach ( $value as $class ) {
            if ( is_array($class) ) {
              $this->set_style(\ephp\web\DefineGuard::define(function() use($class) { return new Style('.', $class); }, 3 + $deep));
            } else if ( is_string($class) && !empty($class) ) {
              $this->attr['class'][] = $class;
            }
          }
        } else {
          $this->attr[$name] = $value;
        }
      } else {
        throw new \Exception('Invalid param in tag [%s]', $value);
      }
    }

  }

  private function set_style(Style $style) {
    if ( $style->is_class() ) $this->styles[] = $style;
    else ($this->style_attr)($style);
  }

  function print_styles() { 
    $classes = [];
    ob_start();
      foreach ( $this->styles as $s ) {
        $s->print();
        $classes[] = $s->class_str();
      }

      if ( !$this->style_attr->can_be_inlined() ) {
        $s = clone $this->style_attr;
        ($s)('.');
        $s->print();
        $classes[] = $s->class_str();
      }

    $style_str = trim(ob_get_clean());

    

    if ( !empty($style_str) ) 
      echo "<style>$style_str</style>";
  
    return $classes;
  }

  

  function open() {
    BuilderState::get()->tag_stack[] = $this;
    $attr = '';
    $classes = [];

    if ( isset($this->id) ) $attr .= sprintf(' id="%s"', $this->id);

    foreach ( $this->attr as $name => $value ) {
      if ( is_null($value) ) continue;
      if ( $name == 'class' ) $classes = $value;
      else {
        $attr .= sprintf(' %s="%s"', $name, htmlspecialchars($value));
      }
    }

    if ( $this->style_attr->isset() ) {
      if ( $this->style_attr->can_be_inlined() )
        $attr .= sprintf(' style="%s"', $this->style_attr->prop_str());
    }


    $classes = array_merge($classes, $this->print_styles());
   
    if ( !empty($classes) ) $attr .= sprintf(' class="%s"', implode(' ', $classes));
    if ( in_array($this->tag, self::SINGLE_TAGS) ) printf('<%s%s/>', $this->tag, $attr);
    else printf('<%s%s>', $this->tag, $attr); 

    return $this;
  }

  function close() {
    if ( !in_array($this->tag, self::SINGLE_TAGS) ) printf('</%s>', $this->tag);
    array_pop(BuilderState::get()->tag_stack);
    return $this;
  }
 
  static function reset() {
    Id::reset_t();
  }
 
  private static function get_id($arg) {
    if ( $arg === '#' ) return Id::t();
    return substr($arg, 1);
  }

  function __invoke($data = null) {
    $this->open();
    if ( is_string($data) ) echo $data ?? '';
    $this->close();
    return $this;
  }

  function html_id() { return $this->id; }

}


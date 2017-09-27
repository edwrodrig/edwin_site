<?php

namespace ephp\web;

class Util {

static function js_html_window($data) {
  ob_start();
?>
window.open(
    "data:text/html;base64,<?=base64_encode($data)?>",
    "_blank",
    "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes")
<?php
  return ob_get_clean();
}

static function js_json_window($data) {
  ob_start();
?>
window.open(
    "data:application/json;base64,<?=base64_encode(json_encode($data))?>",
    "_blank",
    "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes")
<?php
  return ob_get_clean();
}

static function html_string($data) {
  return htmlspecialchars(self::ob_safe($data));
}

static function ob_safe($content) {
  if ( !is_callable($content) ) {
    return strval($content);
  }

  $level = ob_get_level();
  try {
    ob_start();
      $content();
    return ob_get_clean();
  } catch ( \Exception $e ) {
    while ( ob_get_level() > $level ) ob_get_clean();
    throw $e;
  }
}


}

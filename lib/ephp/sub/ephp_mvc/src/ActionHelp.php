<?php
namespace ephp\mvc;

class ActionHelp {

public $request;

/**
* @desc Show help
* @param command Command to show help.
*/
function help($command = null) {
  if ( !isset($command) ) return $this->print_actions();

  $method = $this->request->get_action($command);
  if ( is_null($method) ) return $this->print_actions();

  self::print_action($method['method']);
}

private function print_actions() {
  $comment = self::comment($this->request->get_comment());

  if ( !empty($comment['content']) )
    echo $comment['content'] . "\n\n";

  echo "Available commands:\n";

  foreach ( $this->request->get_actions() as $method ) {
    $comment = self::comment($method->getDocComment());
    printf("  %s  %s\n", str_pad($method->name, 35), $comment['desc'] ?? '');
  }

  echo "\n";
}

private static function print_action(\ReflectionMethod $method) {
  $comment = self::comment($method->getDocComment());
    
  echo $method->getName(), "\n";
  if ( !empty($comment['desc']) ) echo $comment['desc'], "\n";
  
  $params = $method->getParameters();
  if ( count($params) > 0 ) {
    echo "\nParameters:\n";

    foreach ( $params as $param ) {
      $default = '';
      if ( $param->isDefaultValueAvailable() ) {
        $default = sprintf(" (default: %s)", $param->getDefaultValue());
      }
      printf("  %s  %s%s\n", str_pad($param->name, 35), $comment['params'][$param->name] ?? '', $default);
    }
  }
  if ( !empty($comment['content']) ) echo "\nInformation:\n", $comment['content'], "\n";

}

private static function comment(string $comment) {
  $lines = explode("\n",$comment);

  $content = [];
  $params = [];
  $res = [ 'params' => [] ];
  foreach ( $lines as $line ) {
    if ( preg_match('/\/\*/', $line) ) continue;
    if ( preg_match('/\*\//', $line) ) continue;
    $line = preg_replace('/^\s*\*\s/', '', $line);
    if ( strpos($line, '@param') === 0 ) {
      $t = explode(' ', $line, 3);
      $res['params'][$t[1]] = $t[2];
    } else if ( strpos($line, '@desc') === 0 ) {
      $t = explode(' ', $line, 2);
      $res['desc'] = $t[1];
    } else $content[] = $line;
  }
  $res['content'] = implode("\n", $content);
  return $res;
}

}


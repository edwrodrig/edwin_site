<?php
namespace ephp\data;

require_once(__DIR__ . '/Entity.php');

class Data {

public static function __callStatic($name, $args) {
  if ( strpos($name, 'set') === 0 ) {
    return self::set(substr($name, 3), $args[0] ?? []);
  } else if ( strpos($name, 'for') === 0 ) {
    return self::traverse(substr($name, 3), $args[0] ?? null);
  } else return self::new_class($name, $args[0] ?? '');

}

public static function new_class($name, $data) {
  if ( is_string($data) || is_int($data) )
    $data = static::${$name}[$data] ?? null;
  if ( is_null($data) ) return null;
  $class = '\data\\' . $name;
  if ( !class_exists($class) ) $class = '\ephp\data\Entity';
  return new $class($data);
}

private static function set($name, $data) {
  static::${$name} = $data;
}

public static function set_map($name, $data) {
  static::${$name} = [];
  foreach ( $data as $d ) {
    static::${$name}[$d['id']] = $d;
  }
}

private static function traverse($name, $entity = null) {
  $index = 0;

  $entity = $entity ?? $name;
  foreach ( static::${$name} as $value ) {
    yield $index++ => self::new_class($entity, $value);
  }
}

}



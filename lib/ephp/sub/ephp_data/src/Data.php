<?php
namespace ephp\data;

class Data {

public static $default_namespace = 'default';

public static $collections = [];

public static function set($namespace, array $entities = []) {
  self::$collections[$namespace] = new Collections($entities);
}

public static function get($namespace) {
  return self::$collections[$namespace ?? self::$default_namespace];
}

}



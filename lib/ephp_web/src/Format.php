<?php
namespace ephp\web;

class Format {

public static function tr($data) {
  if ( !is_array($data) ) return $data;
  if ( isset($data[Builder::lang()]) ) return self::tr($data[Builder::lang()]);
  

  foreach ( $data as $key => $value ) {
    if ( in_array($key, ['es', 'en'], true) ) return self::tr($value);
    $data[$key] = self::tr($value);
  }

  return $data;
}

public static function date($time) {
  if ( is_string($time) ) $time = strtotime($time);
  $locale = \setlocale(LC_ALL, "0");
  $lang = substr($locale,0, 2);
  if ( $lang === 'es' ) {
    $date = ucwords(strftime('%A %e de %B de %G', $time));
    return str_replace(' De ', ' de ', $date);
  } else if ( $lang === 'en' ) {
    return ucwords(strftime('%A, %B %e, %G', $time));
  } else {
    return strftime('%e/%m/%G', $time);
  }
}

}


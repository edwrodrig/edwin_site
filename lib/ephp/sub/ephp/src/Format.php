<?php
namespace ephp;

class Format {

public static $current_lang = null;

public static $langs = [
  'es' => [
    'value' => 'es',
    'label' => [
      'es' => 'Español',
      'en' => 'Spanish'
    ],
    'locale' => 'es_CL.utf-8'
  ],
  'en' => [
    'value' => 'en',
    'label' => [
      'es' => 'Inglés',
      'en' => 'English'
    ],
    'locale' => 'en_US.utf-8'
  ]
];

public static function set_lang($lang) {
  if ( !isset(self::$langs[$lang]) ) {
    foreach ( self::$langs as $l ) {
       $lang = $l['value'];
       break;
    }
  }

  self::$current_lang = $lang;
  setlocale(LC_ALL, self::$langs[$lang]['locale']);
}

public static function check_tr($data, $lang = null) {
  if ( !is_array($data) ) return $data;
  if ( is_null($lang) ) $lang = self::$current_lang;
  $tr = $data[self::$current_lang] ?? '';
  if ( empty($tr) ) return false;
  return true;
}

public static function tr($data, $lang = null, $warning = true) {
  if ( !is_array($data) ) return $data;
  if ( self::check_tr($data, $lang) ) return $data[$lang ?? self::$current_lang];
  else {
    if ( $warning ) {
      ob_start();
      debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
      $backtrace = ob_get_clean();

      ob_start();
      var_dump($data);
      $dump = ob_get_clean();
      error_log(sprintf('No translation of lang[%s] of data[%s] at [%s]', $lang ?? self::$current_lang, $dump, $backtrace));
    }
    return '';
  }
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


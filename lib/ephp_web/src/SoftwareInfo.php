<?php
namespace ephp\web;

class SoftwareInfo {

public static $type_str = [
"win32" => [
  "installer" => [ "es" => "instalador de windows", "en" => "windows installer" ],
  "exe" => [ "es" => "ejecutable de windows", "en" => "windows executable" ]
],
"osx" => [
  "dmg" => [ "es" => "imagen de disco de apple", "en" => "apple disk image" ]
],
"linux" => [
  "portable" => [ "es" => "binario portable", "en" => "portable binary"],
  "deb" => [ "es" => "paquete de debian", "en" => "debian package"],
],
"ubuntu" => [
  "deb" => [ "es" => "paquete de ubuntu", "en" => "ubuntu package"]
]
];

public static $os_map = [
"Linux" => "linux",
"Win" => "win32",
"Mac" => "osx"
];

public static function type_description($download) {
  return tr(self::$type_str[$download['os']][$download['type']] ?? '');
}

public static function js_data($downloads) {
 foreach ( $downloads as $key => $d ) {
   $downloads[$key]['description'] = self::type_description($d);
 }
?>
(function() {
  var current_os = (function() {
    var p = navigator.platform;
<?php
    foreach ( self::$os_map as $os => $tr ) {
      printf('if ( p.lastIndexOf("%s", 0) === 0 ) return "%s";', $os, $tr);
    }
?>
    return null;
  })();
 
  var data = <?=json_encode($downloads)?>;

  for ( var i = 0 ; i <  data.length ; i++ ) {
    if ( data[i]['os'] === current_os )
      return data[i];
  }
  return null;
})()
<?php
}

}


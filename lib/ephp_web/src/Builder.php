<?php
namespace ephp\web;

class Builder {

public $input_dir = 'files';
public $output_dir = 'output';

private $started = false;

private static $_lang = null;
private static $_output_dir;
private static $_current_output;
private static $_base_url = '';

public static function url(string $url) : string {
  $url = trim($url);
  foreach ( ['//', 'http://', 'https://'] as $protocol ) {
    if ( strpos($url, $protocol) === 0 ) return $url;
  }
  if ( strpos($url, '/') === 0 ) return self::$_base_url . $url;
  return $url;
}

public static function current_url() : string {
  $url = trim(self::$_current_output);
  if ( strpos($url, '/') === 0 ) return $url;
  else return '/' . $url;
}

private function input(string $file) : string {
  return realpath($this->input_dir . DIRECTORY_SEPARATOR . $file);
}

private static function output(string $file) : string {
  return self::$_output_dir . DIRECTORY_SEPARATOR . $file;
}

private function init() {
  if ( $this->started ) return;
  if ( empty(self::$_lang) ) { printf("Error: Not language set!! You must set a language like = es\n"); throw new \Exception("Error: Not language set!! You must set a language like = es\n"); }
  register_shutdown_function(function() { while(ob_get_clean()){;} });
?>
#***********************#
#                       #
#     EPHP  BUILDER     #
#    Edwin Rodriguez    #
#                       #
#***********************#

<?php
  if ( !file_exists($this->input_dir) ) {
    printf("Input directory [%s] does not exists\n", $this->input_dir);
    exit;
  }
  printf("Input directory [%s] found\n", $this->input_dir);

  if ( file_exists($this->output_dir) ) {
    passthru(sprintf('rm -rf %s', $this->output_dir));
  }
  self::$_output_dir = $this->output_dir;
  printf("Output directory [%s] prepared\n", $this->output_dir);

  printf("Language set to [%s]\n", self::$_lang);
  printf("Base url set to [%s]\n", self::$_base_url);

  $this->started = true;

}

public function page_start($output) {
  DefineGuard::reset();
  Style::reset();
  Styles::reset();
  Tag::reset();
  self::$_current_output = $output;
  if ( ob_get_level() == 0 )
    ob_start();
}

public static function lang() { return self::$_lang; }

private static function set_base_url($base_url) {
  self::$_base_url = trim($base_url ?? '');
  self::$_base_url = preg_replace('/\/$/', '', self::$_base_url);
}

private static function set_lang($lang) {
  if ( $lang === 'es' ) setlocale(LC_ALL, 'es_CL.utf-8');
  else setlocale(LC_ALL, 'en_US.utf-8');
  self::$_lang = $lang;
}

public static function page_end() {
  while ( ob_get_level() > 1 )
    echo ob_get_clean();
  if ( ob_get_level() == 1 ) {
    file_put_contents(self::prepare_current_output(), ob_get_clean());
    printf("Page [%s] generated\n", self::$_current_output);
  }
}

private static function prepare_current_output($file = null) {
  $output = self::output($file ?? self::$_current_output);
  passthru(sprintf('mkdir -p %s', dirname($output)));
  return $output;
}

public function __set($name, $value) {
  if ( $name === 'lang' )
    self::set_lang($value);
  else if ( $name === 'base_url' ) {
    self::set_base_url($value);
  }
}

public function __invoke(...$files) {
  $this->init();
  foreach ( $files as $file) {
    $input = $this->input($file);
    if ( !file_exists($input) ) {
      printf("File not exists [%s]...Skipped\n", $file);
    } else if ( is_dir($input) ) {
      printf("Processing directory [%s]...\n", $file);
      foreach ( scandir($input) as $key => $dir_file) {
        if ( $key < 2 ) continue;
        if ( $file === '.' ) $this($dir_file);
        else $this($file . DIRECTORY_SEPARATOR . $dir_file);
      }
      printf("Directory [%s] completed\n", $file);
    } else {
      if ( preg_match( '/\.php$/', $input) ) {
        printf("Processing file [%s]...\n", $file);
        $this->page_start(preg_replace('/\.php$/', '', $file));
        require($input);
        self::page_end();
        printf("File [%s] processed\n", $file);
      } else if ( !preg_match('/\.swp$/', $input) ) {
        passthru(sprintf("cp %s %s", $input, self::prepare_current_output($file)));
        printf("File [%s] copied\n", $file);
      }
    }
  }
}

}


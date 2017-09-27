# ephp_mvc
PHP function wrappers for services and console apps

## How it looks

```php
//Some class with the actions
class Actions {

function add($arg1, $arg2) { return $arg1 + $arg2; }

function sub($arg1, $arg2) { return $arg1 - $arg2; }

function sort($arg1, $arg2) {
  return [
    'min' => min($arg1, $arg2),
    'max' => max($arg1, $arg2)
  ];
}

}

//Register the actions
(new class extends \ephp\mvc\Loader {
  function http_json() { return new Actions; }
})();
```

## Demo
Run the following commands to download and run the demo

```sh
php -d allow_url_include=On -r "require('https://raw.githubusercontent.com/edwrodrig/ephp_mvc/master/scripts/demo.php');"
cd demo_ephp_mvc
php -S localhost:8080
```

Then open the following url `http://localhost:8080?action=add&arg1=2&arg2=2`

## How to include this library in my code
Run the following command to download the code
```sh
php -d allow_url_include=On -r "require('https://raw.githubusercontent.com/edwrodrig/ephp_mvc/master/scripts/lib.php');"
```
You will see a `ephp_mvc` folder with a `include.php` file. Just include that file in your project.
```php
require('path/to/ephp_mvc/include.php');

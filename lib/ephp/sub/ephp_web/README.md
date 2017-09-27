# ephp
Static site generator PHP library

## Why I created this?
I'm not a web developer and I hate the technologies related. So I need to do something to deal the least possible with it. From different code formats to server management. I realized that in most of times only static sites are needed. Moreover, if you want dynamic stuff you can deal with it front-end javascript plus http services (xml, json, plain, etc). I see there are many static site generators and generally are library frankesteins that usually forces you to use more formats like markdown, template languages, etc., if with html, css, js we don't have enough. Other static generators like Jekyll are nice but to simple, for example there is no easy way to wrap some code in functions. Also when I install it in ubuntu it installed nodejs, python, and ruby libraries. When I see that I almost throw up. PHP is itself a template engine so other libs like Smarty are not really needed, just use plain PHP with output buffers. Moreover, why I have to learn to write if and for loops in a template engine language, where PHP itselt is more powerful that them. Just nosense.

## Design objetives
  - Usage plain php files without imposing the usage of functions of libs where it is not needed.
  - Elimination of the need of naming styles or any css administration.
  - Ability to reutilize html/css as one unit.
  - Ways to hide javascript code.
  - Multiple-language support

## How to include this library in my code
Run the following command to download the code
```sh
php -d allow_url_include=On -r "require('https://raw.githubusercontent.com/edwrodrig/ephp/master/scripts/lib.php');"
```
You will see a `ephp` folder with a `include.php` file. Just include that file in your project.
```php
require('path/to/ephp_web/include.php');
```

## Examples done with this library

 - [Millenium Institute of Oceanography](http://www.imo-chile.cl)
 - [My page](http://edwin.cl)
 - [My page source code](https://github.com/edwrodrig/edwin_site)
 - [A psycologist website](http://amandamorales.cl)
 - [Aprende scientific initiative](http://a-prendechile.cl)

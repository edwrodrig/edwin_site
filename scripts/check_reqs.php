<?php

use edwrodrig\image\Image;
use edwrodrig\static_generator\Site;

include_once __DIR__ . '/../vendor/autoload.php';

if ( Site::check_locales('es_CL.utf8') &&
     Image::check_svg_converter() )
    exit(0);
else
    exit(1);



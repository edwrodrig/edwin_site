<?php

use edwrodrig\static_generator\Site;

include_once __DIR__ . '/../vendor/autoload.php';

if ( Site::check_locales('es_CL.utf8') )
    exit(0);
else
    exit(1);

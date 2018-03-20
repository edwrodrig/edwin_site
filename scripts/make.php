<?php

include __DIR__ . '/../vendor/autoload.php';

use edwrodrig\static_generator\ResourceMinifier;
use edwrodrig\js\Config;

$res = new ResourceMinifier;
$res->sources = [
    Config::RESOURCE_DIR . '/anim.js'
];

$res->js()->minify(__DIR__ . '/../files/lib.js');

$site = new edwrodrig\static_generator\Site;
$site->input_dir = __DIR__ . '/../files';
$site->output_dir = __DIR__ . '/../output';

$site->regenerate();
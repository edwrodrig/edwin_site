<?php

include __DIR__ . '/../vendor/autoload.php';

use edwrodrig\contento\collection\json\Collection;
use edwrodrig\site\data\Project;
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

$site->globals['posts'] = Collection::create_from_elements($site->get_templates('post'));
$site->globals['projects'] = Collection::create_from_json(__DIR__ . '/../data/projects.json', Project::class);

$site->regenerate();
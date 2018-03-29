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

setlocale(LC_ALL, 'es_CL.utf8');
//setlocale(LC_ALL, 'en_US.utf-8');

$site = new edwrodrig\static_generator\Site;
$site->input_dir = __DIR__ . '/../files';
$site->output_dir = __DIR__ . '/../output';
$site->set_base_url('https://www.edwin.cl');

$site->globals['posts'] = Collection::create_from_elements($site->get_templates('post'));
$site->globals['projects'] = Collection::create_from_json(__DIR__ . '/../data/projects.json', Project::class);

$site->globals['posts']->reverse_sort();
$site->globals['projects']->reverse_sort();

$site->regenerate();
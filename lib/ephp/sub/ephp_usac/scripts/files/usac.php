<?php

require_once(__DIR__ . '/..' . '/src/include.php');

$config = json_decode(file_get_contents(__DIR__ . '/../data/config.json'), true);
$config['usac']['db'] = __DIR__ . '/../data/usac.db';

$loader = new \ephp\usac\Loader;
$loader->set_config($config);

$loader();


<?php

include __DIR__ . '/../vendor/autoload.php';

use edwrodrig\contento\collection\json\Collection;
use edwrodrig\contento\collection\json\Singleton;
use edwrodrig\site\data\DataManager;
use edwrodrig\site\data\Project;
use edwrodrig\site\data\SiteInfo;
use edwrodrig\static_generator\cache\CacheManager;

$data = new DataManager;


$cache = new CacheManager(__DIR__ . '/../output/cache/images');
    $cache->setTargetWebPath('cache/images');

$context = new \edwrodrig\static_generator\Context(__DIR__ . '/../files', __DIR__ . '/../output/es');
    $context->data = $data;
    $context->data->setContext($context);
    $context->registerCache($cache);
    $context->setTargetWebPath('es');
    setlocale(LC_ALL, 'es_CL.utf-8');

    $context->generate();


    $cache->save();



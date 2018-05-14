<?php

include __DIR__ . '/../vendor/autoload.php';

use edwrodrig\contento\collection\json\Collection;
use edwrodrig\contento\collection\json\Singleton;
use edwrodrig\site\data\Project;
use edwrodrig\site\data\SiteInfo;
use edwrodrig\static_generator\cache\CacheManager;

$site->globals['posts'] = Collection::create_from_elements($site->get_templates('post'));
$site->globals['projects'] = Collection::create_from_json(__DIR__ . '/../data/projects.json', Project::class);
$site->globals['site_info'] = Singleton::create_from_json(__DIR__ . '/../data/site_info.json', SiteInfo::class);

$site->globals['posts']->reverse_sort();
$site->globals['projects']->reverse_sort();


$cache = new CacheManager(__DIR__ . '/../output/cache/images');
    $cache->setTargetWebPath('cache/images');

$context = new \edwrodrig\static_generator\Context(__DIR__ . '/../files', __DIR__ . '/../output/es');
    $context->registerCache($cache);
    $context->setTargetWebPath('es');
    setlocale(LC_ALL, 'es_CL.utf-8');

    $context->generate();


    $cache->save();



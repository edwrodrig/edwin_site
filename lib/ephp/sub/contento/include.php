<?php

if ( !defined('CONTENTO') ) : define('CONTENTO', true);

require_once(__DIR__ . '/..' . '/ephp_usac/include.php');
require_once(__DIR__ . '/..' . '/contento_type/include.php');

require_once(__DIR__ . '/src/TypeUpdater.php');
require_once(__DIR__ . '/src/CollectionBuilder.php');
require_once(__DIR__ . '/src/data/Error.php');
require_once(__DIR__ . '/src/data/Db.php');
require_once(__DIR__ . '/src/data/Model.php');
require_once(__DIR__ . '/src/data/ActionsHttp.php');

require_once(__DIR__ . '/src/image/Error.php');
require_once(__DIR__ . '/src/image/Db.php');
require_once(__DIR__ . '/src/image/Model.php');
require_once(__DIR__ . '/src/image/ActionsHttp.php');

require_once(__DIR__ . '/src/ActionsConsole.php');
require_once(__DIR__ . '/src/ActionsConsoleInstall.php');
require_once(__DIR__ . '/src/Loader.php');
require_once(__DIR__ . '/src/Client.php');

endif;

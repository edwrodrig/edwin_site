<?php

if ( !defined('EPHP_USAC') ) : define('EPHP_USAC', true);

require_once(__DIR__ . '/..' . '/ephp_tokac/include.php');
require_once(__DIR__ . '/..' . '/ephp_mail/include.php');

require_once(__DIR__ . '/src/Error.php');
require_once(__DIR__ . '/src/Db.php');
require_once(__DIR__ . '/src/Loader.php');
require_once(__DIR__ . '/src/Model.php');
require_once(__DIR__ . '/src/FilterSession.php');
require_once(__DIR__ . '/src/ActionsConsoleInstall.php');
require_once(__DIR__ . '/src/ActionsConsole.php');
require_once(__DIR__ . '/src/ActionsHttp.php');
require_once(__DIR__ . '/src/ActionsMailRequest.php');
require_once(__DIR__ . '/src/ActionsTokac.php');
require_once(__DIR__ . '/src/MailTemplates.php');
require_once(__DIR__ . '/src/Client.php');

endif;




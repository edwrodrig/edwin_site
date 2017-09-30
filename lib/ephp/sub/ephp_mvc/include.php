<?php
if ( !defined('EPHP_MVC') ) : define('EPHP_MVC', true);

require_once(__DIR__ . '/..' . '/ephp/include.php');
require_once(__DIR__ . '/..' . '/ephp_mail/include.php');

require_once(__DIR__ . '/src/ActionHelp.php');
require_once(__DIR__ . '/src/ActionMailTest.php');
require_once(__DIR__ . '/src/Error.php');
require_once(__DIR__ . '/src/Loader.php');

require_once(__DIR__ . '/src/Request.php');
require_once(__DIR__ . '/src/RequestArray.php');
require_once(__DIR__ . '/src/RequestAssoc.php');
require_once(__DIR__ . '/src/RequestJson.php');
require_once(__DIR__ . '/src/RequestConsole.php');
require_once(__DIR__ . '/src/RequestHttp.php');

require_once(__DIR__ . '/src/Response.php');
require_once(__DIR__ . '/src/ResponseAssoc.php');
require_once(__DIR__ . '/src/ResponseJson.php');
require_once(__DIR__ . '/src/ResponseHttp.php');

require_once(__DIR__ . '/src/MailSender.php');
require_once(__DIR__ . '/src/Client.php');

endif;




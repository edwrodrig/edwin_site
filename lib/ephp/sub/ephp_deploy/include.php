<?php

if ( !defined('EPHP_DEPLOY') ) : define('EPHP_DEPLOY', true);

require_once(__DIR__ . '/../ephp/include.php');

require_once(__DIR__ . '/src/Copy.php');
require_once(__DIR__ . '/src/Ssh.php');
require_once(__DIR__ . '/src/Github.php');
require_once(__DIR__ . '/src/Rsync.php');

endif;

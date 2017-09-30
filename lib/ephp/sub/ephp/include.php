<?php
if ( !defined('EPHP') ) : define('EPHP', true);

require_once(__DIR__ . '/src/Util.php');
require_once(__DIR__ . '/src/Error.php');
require_once(__DIR__ . '/src/SingleProcess.php');
require_once(__DIR__ . '/src/Format.php');
require_once(__DIR__ . '/src/Image.php');

function tr($data) { return \ephp\Format::tr($data); }

endif;




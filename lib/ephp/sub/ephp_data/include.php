<?php

if ( !defined('EPHP_DATA') ) : define('EPHP_DATA', true);

require_once(__DIR__ . '/src/functions.php');
require_once(__DIR__ . '/src/Collections.php');
require_once(__DIR__ . '/src/Collection.php');
require_once(__DIR__ . '/src/Entity.php');
require_once(__DIR__ . '/src/EntityDuration.php');
require_once(__DIR__ . '/src/Data.php');


function data($namespace = null) {
  return \ephp\data\Data::get($namespace);
}

endif;

<?php
require_once(__DIR__  . '/include.php');

\ephp\web\usac\Client::$default_server = 'http://localhost:8081/contento.php';
\ephp\web\tokac\Client::$default_server = 'http://localhost:8081/contento.php';

\theme\usac\Site::$signin_enabled = true;
\theme\usac\Site::$guest_enabled = true;

$b = new \ephp\web\Builder;

$b->input_dir = 'files';
$b->output_dir = 'output';
$b->lang = 'es';

$b('.');


<?php
require_once(__DIR__  . '/include.php');

$server = 'http://localhost:8081' . '/contento.php';

\ephp\web\usac\Client::$default_server = $server;
\ephp\web\tokac\Client::$default_server = $server;
\theme\contento\Client::$default_server = $server;

$client = new \contento\Client($server);
$client->login('edwin', 'pass');
$collections = $client->collections();

$b = new \ephp\web\Builder;

$b->input_dir = 'files';
$b->output_dir = 'output';
$b->lang = 'es';

$b('.');


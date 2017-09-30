<?php
require_once(__DIR__ . '/include.php');

$b = new ephp\web\Builder;
$b->lang = 'es';

Client::$default_server = '/server.php';

$b('.');

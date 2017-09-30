<?php

require_once(__DIR__ . '/..' . '/src/include.php');

$config = json_decode(file_get_contents(__DIR__ . '/../data/config.json'), true);

\ephp\usac\ActionsJson::$user_login_guest_enabled = $config['login_guest_enabled'];
\ephp\usac\ActionsJson::$user_request_signin_enabled = $config['user_request_signin_enabled'];

$loader = new \contento\Loader;
$loader->config = $config;
$loader->mail_sender = new \ephp\usac\ViewMailRequest;
$loader->mail_sender->page_url = $config['mail']['page_url'];
$loader->mail_sender->from_text = $config['mail']['from_text'];
$loader->config['types_folder'] = __DIR__ . '/../data/types';
$loader->config['db'] = __DIR__ . '/../data/contento.db';

\ephp\mail\Smtp::$default_credentials = array_merge(\ephp\mail\Smtp::$default_credentials, $config['mail']);

$loader();


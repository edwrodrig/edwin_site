<?php
require_once(__DIR__ . '/include.php');

\ephp\web\contento\Input::$template = new TemplateElem;

$b = new ephp\web\Builder;
$b->lang = 'es';

$b('.');
$b->finalize();

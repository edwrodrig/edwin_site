<?php
require_once(__DIR__  . '/include.php');


$b = new \ephp\web\Builder;

$b->input_dir = 'files';
$b->output_dir = 'output';
$b->lang = 'es';

$b('.');


#!/usr/bin/php
<?php
require_once(__DIR__ . '/include.php');

$d = new \ephp\deploy\Github();
$d->user = 'edwrodrig';
$d->target = 'edwrodrig.github.io';

$d();


<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 29-03-18
 * Time: 22:54
 */

require_once(__DIR__ . '/../vendor/autoload.php');

$d = new edwrodrig\deployer\Github;
$d->user = 'edwrodrig';
$d->target = 'edwrodrig.github.io';
$d->source = __DIR__ . '/../output/es';

$d();
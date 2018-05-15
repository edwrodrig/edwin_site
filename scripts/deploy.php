<?php

include_once __DIR__ . '/../vendor/autoload.php';

$github = new edwrodrig\deployer\Github;

$github
    ->setTargetUser('edwrodrig')
    ->setTargetRepoName('edwrodrig.github.io')
    ->setTargetRepoBranch('master')
    ->setSourceDir(__DIR__ . '/../output/es');

$github->getSsh()->setIdentityFile(__DIR__ . '/../config/id_rsa');


echo $github->execute();

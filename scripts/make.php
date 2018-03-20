<?php

include __DIR__ . '/../vendor/autoload.php';

$site = new edwrodrig\static_generator\Site;
$site->input_dir = __DIR__ . '/../files';
$site->output_dir = __DIR__ . '/../output';

$site->regenerate();
<?php
declare(strict_types=1);

use edwrodrig\mypage\ws\Controller;

include_once(__DIR__ . '/../../../vendor/autoload.php');

$_ENV['ERROR_LOG_FILENAME'] = __DIR__ . '/../error_log';

(new Controller())->run();
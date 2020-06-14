<?php
declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use labo86\exception_with_data\ExceptionWithData;
use edwrodrig\mypage\site\Builder;



try {
    $builder = new Builder();
    $builder->makeSite(__DIR__ . '/../modules/data/html', __DIR__ . '/../modules/www');
} catch ( ExceptionWithData $exception ) {
    echo $exception->getMessage(), "\n";
    echo json_encode($exception->getData(),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), "\n";
    echo $exception->getFile() , ":" , $exception->getLine() ,"\n";
    echo json_encode($exception->getTrace(),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), "\n";
} catch ( Throwable $exception ) {
    echo $exception->getMessage(), "\n";
    echo $exception->getFile() , ":" , $exception->getLine() ,"\n";
    echo json_encode($exception->getTrace(),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), "\n";
}
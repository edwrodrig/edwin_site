<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 26-03-18
 * Time: 22:40
 */

include_once __DIR__ . '/../vendor/autoload.php';


foreach ( [16, 24, 32, 46, 64, 57, 72, 114, 120, 144, 152] as $size ) {

    $img = \edwrodrig\image\Image::optimize(__DIR__ . '/../data/images/favicon.png');
    $img->scaleImage($size, $size);
    $img->writeImage(__DIR__ . '/../files/assets/favicon-' . $size . '.png');

}

$img = \edwrodrig\image\Image::optimize(__DIR__ . '/../data/images/browser.svg', 100);
$img->scaleImage(200, 200);
$img->writeImage(__DIR__ . '/../files/assets/project-default-icon.png');
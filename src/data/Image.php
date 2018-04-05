<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03-04-18
 * Time: 14:38
 */

namespace edwrodrig\site\data;

use edwrodrig\site\Site;
use edwrodrig\static_generator\cache\ImageItem;

class Image extends ImageItem
{
    public function __construct(string $file, string $suffix = '') {
        parent::__construct(__DIR__  . '/../../data', $file, $suffix);
        $this->output_folder = '/assets';
        $this->set_salt();
    }

    public function __toString() : string {
        return (string)Site::cache()->update_cache($this);
    }

    public static function image($file, int $size_hint = 1000) {
        $img = new Image($file);
        $img->set_size_hint($size_hint);
        return $img;
    }

    public static function cover($file, $width, $height, int $size_hint = 1000) {
        $img = new Image($file);
        $img->set_size_hint($size_hint);
        $img->set_cover($width, $height);
        return $img;
    }

    public static function contain($file, $width, $height, $background_color = 'transparent', int $size_hint = 1000) {
        $img = new Image($file);
        $img->set_size_hint($size_hint);
        $img->set_contain($width, $height, $background_color);
        return $img;
    }
}

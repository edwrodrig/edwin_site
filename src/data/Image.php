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
    }

    public function __toString() : string {
        return (string)Site::cache()->update_cache($this);
    }

    public static function image($file, int $svg_factor = 1) {
        $img = new Image($file);
        $img->svg_factor = $svg_factor;
        return $img;
    }

    public static function cover($file, $width, $height, int $svg_factor = 1) {
        $img = new Image($file);
        $img->svg_factor = $svg_factor;
        $img->set_cover($width, $height);
        return $img;
    }

    public static function contain($file, $width, $height, $background_color = 'transparent', int $svg_factor = 1) {
        $img = new Image($file);
        $img->svg_factor = $svg_factor;
        $img->set_contain($width, $height, $background_color);
        return $img;
    }
}

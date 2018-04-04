<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03-04-18
 * Time: 14:38
 */

namespace edwrodrig\site\data;

use edwrodrig\static_generator\cache\Cache;
use edwrodrig\static_generator\cache\FileItem;
use edwrodrig\site\Site;

class Image extends FileItem
{
    public function __construct(string $file, string $suffix = '') {
        parent::__construct(__DIR__  . '/../../data', $file, $suffix);
        $this->output_folder = '/assets';
    }

    public function __toString() : string {
        return (string)Site::cache()->update_cache($this);
    }


    public static function image($file) {
        return  new class($file) extends Image {
            public function cache_generate(Cache $cache) {
                $img = \edwrodrig\image\Image::optimize($this->get_source_filename($this->filename));
                $img->writeImage($cache->cache_filename($this->get_cached_file()));
            }

        };
    }

    public static function resize_fit($file, $width, $height, int $svg_factor = 1) {
        $img = new class($file, $width . 'x' . $height) extends Image {
            public $width;
            public $height;
            public $svg_factor;

            public function cache_generate(Cache $cache) {
                $img = \edwrodrig\image\Image::optimize($this->get_source_filename($this->filename), $this->svg_factor);
                $img->setImageBackgroundColor('transparent');
                $img->scaleImage($this->width, $this->height);
                $img->writeImage($cache->cache_filename($this->get_cached_file()));
            }

        };
        $img->width = $width;
        $img->height = $height;
        $img->svg_factor = $svg_factor;
        if ( pathinfo($file, PATHINFO_EXTENSION) == 'svg' )
            $img->extension = 'png';
        return $img;
    }

    public static function resize_width($file, $width) {
        $img = new class($file, $width . 'x') extends Image {
            public $width;

            public function cache_generate(Cache $cache) {
                $img = \edwrodrig\image\Image::optimize($this->get_source_filename($this->filename));
                $img->scaleImage($this->width, 0);
                $img->writeImage($cache->cache_filename($this->get_cached_file()));
            }

        };

        $img->width = $width;
        return $img;
    }



}

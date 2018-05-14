<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 28-03-18
 * Time: 6:20
 */

namespace edwrodrig\site;

use DateTime;
use edwrodrig\site\data\Image;
use edwrodrig\site\data\Project;
use edwrodrig\static_generator\Page;
use edwrodrig\static_generator\Site as BaseSite;

class Site
{
    public static function posts() {
        return BaseSite::get()->globals['posts'];
    }

    public static function projects() {
        return BaseSite::get()->globals['projects'];
    }

    public static function site_info() {
        return BaseSite::get()->globals['site_info'];
    }
}
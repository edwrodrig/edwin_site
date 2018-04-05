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

    public static function cache() {
        return BaseSite::get()->globals['cache'];
    }

    public static function lang() : string {
        return BaseSite::get()->get_lang();
    }

    public static function tr($translatable, $default = null) : string {
        return BaseSite::get()->tr($translatable, $default);
    }

    public static function page() {
        return Page::get();
    }

    public static function html_project_box(Project $project) {?>
        <a href="<?=$project->get_url()?>" class="project-box clickable-box">
            <div class="grid-padding">
                <div class="project-logo">
                    <img width="100px" height="100px" src="<?=Image::contain('images/projects/' . ($project->get_image() ?? 'default.svg'), 200, 200,  'transparent',400)?>"/>
                </div>
                <div>
                    <h2><?=$project->get_name()?></h2>
                    <p><?=Site::tr($project->get_description(), '')?></p>
                </div>
            </div>
        </a>
    <?php
    }

    public static function absolute_url(string $url) {
        return BaseSite::get()->url($url);
    }

    public static function date_str(DateTime $date) : string {
        $locale = \setlocale(LC_TIME, "0");
        $lang = substr($locale,0, 2);
        if ( $lang === 'es' ) {
            $date = ucwords(strftime('%A %e de %B de %G',  $date->getTimestamp()));
            return str_replace(' De ', ' de ', $date);
        } else if ( $lang === 'en' ) {
            return ucwords(strftime('%A, %B %e, %G', $date->getTimestamp()));
        } else {
            return strftime('%e/%m/%G', $date->getTimestamp());
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 02-04-18
 * Time: 14:21
 */

namespace edwrodrig\site\data;


use edwrodrig\contento\type\TranslatableString;

class SiteInfo
{
    /**
     * @var TranslatableString
     */
    private $title;

    /**
     * @var TranslatableString
     */
    private $description;

    public static function create_from_array(array $data) {
        $o = new self;
        $o->title = new TranslatableString($data['title']);
        $o->description = new TranslatableString($data['description']);
        return $o;
    }

    public function get_title() : ?TranslatableString {
        return $this->title;
    }

    public function get_description() : ?TranslatableString {
        return $this->description;
    }

}
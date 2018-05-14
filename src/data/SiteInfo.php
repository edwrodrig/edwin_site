<?php
declare(strict_types=1);

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

    public static function createFromArray(array $data) {
        $o = new self;
        $o->title = new TranslatableString($data['title']);
        $o->description = new TranslatableString($data['description']);
        return $o;
    }

    public function getTitle() : TranslatableString {
        return $this->title;
    }

    public function getDescription() : TranslatableString {
        return $this->description;
    }

}
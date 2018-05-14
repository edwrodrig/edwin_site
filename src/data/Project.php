<?php
declare(strict_types=1);

namespace edwrodrig\site\data;

use edwrodrig\contento\type\TranslatableString;
use edwrodrig\contento\type\Url;

class Project
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var TranslatableString
     */
    private $description;

    /**
     * @var ?string
     */
    private $image;

    /**
     * @var Url
     */
    private $url;

    /**
     * @var int
     */
    private $importance;

    /**
     * @param array $data
     * @return Project
     * @throws \edwrodrig\contento\type\exception\InvalidUrlException
     */
    public static function createFromArray(array $data) : self
    {
        $r = new self;
        $r->name = $data['name'];
        $r->description = new TranslatableString($data['description']);
        $r->image = $data['image'] ?? null;
        $r->url = new Url($data['url']);
        $r->importance = $data['importance'] ?? 0;

        return $r;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : TranslatableString
    {
        return $this->description;
    }

    public function getImage() : ?string
    {
        return $this->image;
    }

    public function getUrl() : Url
    {
        return $this->url;
    }

    public function getId() : string {
        return $this->getName();
    }

    public static function compare(Project $a, Project $b) {
        return $a->importance <=> $b->importance;
    }
}
<?php
declare(strict_types=1);

namespace edwrodrig\mypage\model;

class Project
{
    private string $name;

    private string $description;

    private string $image;

    private string $url;

    private int $importance;

    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->image = $data['image'] ?? 'default.svg';
        $this->url = $data['url'];
        $this->importance = $data['importance'] ?? 0;
    }

    public function getId() : string {
        return $this->getName();
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getImage() : ?string
    {
        return $this->image;
    }

    public function getAbsoluteUrl() : string
    {
        return $this->url;
    }

    public function getImportance() : int {
        return $this->importance;
    }
}
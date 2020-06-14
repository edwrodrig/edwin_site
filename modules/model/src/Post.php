<?php
declare(strict_types=1);

namespace edwrodrig\mypage\model;

use DateTime;
use labo86\staty_core\PagePhp;

class Post
{
    private string $title;

    private string $description;

    private DateTime $publication_date;

    private string $relative_url;

    public function __construct(PagePhp $page) {
        $data = $page->getMetadata();
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->publication_date = new DateTime($data['publication_date'] ?? null);
        $this->relative_url = $page->getRelativeFilename();
    }


    public function getTitle() : string {
        return $this->title;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function getPublicationDate() : DateTime {
        return $this->publication_date;
    }

    public function getRelativeUrl() : string {
        return $this->relative_url;
    }
}
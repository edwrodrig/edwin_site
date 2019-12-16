<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14-05-18
 * Time: 17:17
 */

namespace edwrodrig\site\data;


use DateTime;
use edwrodrig\contento\type\TranslatableString;

class Post
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var TranslatableString
     */
    private TranslatableString $title;

    /**
     * @var TranslatableString
     */
    private TranslatableString $description;

    /**
     * @var DateTime
     */
    private DateTime $publication_date;

    public static function createFromArray(array $data) {
        $post = new self;
        $post->id = $data['id'];
        $post->title = new TranslatableString($data['title']);
        $post->description = new TranslatableString($data['description']);
        $post->publication_date = new DateTime($data['date']);
        return $post;
    }


    public function getId() : string {
        return $this->id;
    }

    public function getUrl() : string {
        return '/posts/' . $this->getId();
    }

    public function getTitle() : TranslatableString {
        return $this->title;
    }

    public function getDescription() : TranslatableString {
        return $this->description;
    }

    /**
     * Return the publication date of the post
     * @return DateTime
     */
    public function getPublicationDate() : DateTime {
        return $this->publication_date;
    }

    static public function compare(Post $a, Post $b) {
        return $a->getPublicationDate() <=> $b->getPublicationDate();
    }
}
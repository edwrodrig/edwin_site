<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 20-03-18
 * Time: 13:44
 */

namespace edwrodrig\site;

use edwrodrig\contento\type\Url;

class Project
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Url
     */
    private $image;

    /**
     * @var Url
     */
    private $url;

    /**
     * @param array $data
     * @return Project
     * @throws \edwrodrig\contento\type\exception\InvalidUrlException
     */
    public static function create_from_array(array $data) : self
    {
        $r = new self;
        $r->name = $data['name'];
        $r->description = $data['description'];
        $r->image = new Url($data['image']);
        $r->url = new Url($data['url']);

        return $r;
    }

    public function get_name() : string
    {
        return $this->name;
    }

    public function get_description() : string
    {
        return $this->description;
    }

    public function get_image() : Url
    {
        return $this->image;
    }

    public function get_url() : Url
    {
        return $this->url;
    }

    public function get_id() : string {
        return $this->get_name();
    }

}
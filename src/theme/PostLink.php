<?php
declare(strict_types=1);

namespace edwrodrig\site\theme;

use edwrodrig\site\data\Post;

/**
 * Class PostBox
 * @package edwrodrig\site\theme
 */
class PostLink
{
    /**
     * @var Post
     */
    private $post;

    /**
     * @var TemplatePage
     */
    private $template;

    public function __construct(Post $post, TemplatePage $template) {
        $this->post = $post;
        $this->template = $template;
    }

    public function getUrl() : string {
        return $this->template->url($this->getUrl());
    }

    public function getTitle() : string {
        return $this->template->tr($this->post->getTitle());
    }

    public function getPublicationDate() : string {
        return $this->template->dateStr($this->post->getPublicationDate());
    }

    public function html() {?>
        <a href="<?=$this->getUrl()?>" class="clickable-box post-box">
            <h2><?=$this->getTitle()?></h2>
            <time><i class="fa fa-clock-o"></i><?=$this->getPublicationDate()?></time>
        </a>
        <?php
    }

}
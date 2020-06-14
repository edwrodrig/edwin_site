<?php
declare(strict_types=1);

namespace edwrodrig\mypage\site;

use edwrodrig\mypage\model\Post;
use labo86\staty_core\PagePhp;

class BlockPostLink extends BlockPage
{
    private Post $post;

    public function __construct(PagePhp $page, Post $post) {
        parent::__construct($page);
        $this->post = $post;
    }

    public function html() {?>
        <a href="<?=$this->post->getRelativeUrl()?>" class="clickable-box post-box">
            <h2><?=$this->post->getTitle()?></h2>
            <time><i class="fa fa-clock-o"></i><?=$this->date($this->post->getPublicationDate())?></time>
        </a>
        <?php
    }

}
<?php
declare(strict_types=1);

namespace edwrodrig\mypage\site;

use edwrodrig\mypage\model\Post;
use labo86\staty_core\PagePhp;

/**
 * Class BlockPagePost
 * @package edwrodrig\mypage\site
 */
class BlockPagePost extends BlockPage
{
    private Post $post;

    public function __construct(PagePhp $page) {
        parent::__construct($page);
        $this->post = new Post($page);
    }


    public function sectionBeginPostContent() {
        $this->sectionBegin('post_content');
    }

    public function html() {
        $this->sectionEnd();?>
<!doctype html>
<html lang="es">
<head>
    <?php $this->htmlHeadCommon()?>
    <?php $this->htmlHeadCommonMeta()?>
    <title><?=$this->post->getTitle()?></title>
    <?=$this->getSectionContent('head_additional')?>
</head>
<body>
    <?php $this->htmlBodyHeader()?>
    <div>
        <div class='section-container container-padding'>
            <header class="section-header post-box">
                <h1><?=$this->post->getTitle()?></h1>
                <time><i class="fa fa-clock-o"></i><?=$this->date($this->post->getPublicationDate())?></time>
            </header>
            <hr/>
            <div class="paragraph">
                <?=$this->getSectionContent('post_content')?>
            </div>
        </div>
    </div>
    <?php $this->htmlBodyFooter()?>
</body>
</html>
<?php
    }



}
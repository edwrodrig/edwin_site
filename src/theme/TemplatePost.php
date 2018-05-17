<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 19-03-18
 * Time: 22:34
 */

namespace edwrodrig\site\theme;

use edwrodrig\site\data\Post;
use edwrodrig\static_generator\PagePhp;

class TemplatePost extends TemplatePage
{
    /**
     * @var Post
     */
    private $post;

    public function __construct(PagePhp $page_info) {
        parent::__construct($page_info);
        $this->post = Post::createFromArray($this->getData());
    }

    public function getPost() : Post {
        return $this->post;
    }

    public function getData() : array {
        $data = parent::getData();
        $data['id'] = $this->getId();
        return $data;
    }

    public function getTemplateType() : string {
        return 'post';
    }

    /**
     * @return string
     * @throws \edwrodrig\static_generator\exception\NoTranslationAvailableException
     */
    public function getTitle() : string {
        return $this->tr($this->post->getTitle());
    }

    public function getPublicationDate() : string {
        return $this->dateStr($this->post->getPublicationDate());
    }

    public function bodyContent() {?>
<div>
    <div class='section-container container-padding'>
        <header class="section-header post-box">
            <h1><?=$this->getTitle()?></h1>
            <time><i class="fa fa-clock-o"></i><?=$this->getPublicationDate()?></time>
        </header>
        <hr/>
        <div class="paragraph">
        <?php
            parent::bodyContent();
        ?>
        </div>
    </div>
</div>
<?php
    }


}
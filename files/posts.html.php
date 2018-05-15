<?php
/**
 * @template \edwrodrig\site\theme\TemplatePage
 *
 * @data {
 *   "title" : {
 *       "es" : "Artículos",
 *       "en" : "Posts"
 *   }
 * }
 * @var $this \edwrodrig\site\theme\TemplatePage
 */

use edwrodrig\site\theme\PostLink;

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=$this->tr($this->getTitle())?></h1>
        </header>
        <hr>
        <div class="flex-column grid-padding">
        <?php
            foreach ( $this->getData()->getPosts() as $post ) {?>
            <div>
                <?php (new PostLink($post, $this))->html()?>
            </div>
            <?php
            }
        ?>
        </div>
    </div>
</div>
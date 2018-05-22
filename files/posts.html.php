<?php
/**
 *
 * @data {
 *   "title" : {
 *       "es" : "Artículos",
 *       "en" : "Posts"
 *   }
 * }
 * @var $this \edwrodrig\site\theme\TemplatePage
 */

use edwrodrig\site\data\Repository;
use edwrodrig\site\theme\PostLink;

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=$this->getTitle()?></h1>
        </header>
        <hr>
        <div class="flex-column grid-padding">
        <?php foreach ( Repository::get($this)->getPosts() as $post ) : ?>
            <div>
                <?php (new PostLink($post, $this))->html()?>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</div>
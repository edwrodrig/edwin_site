<?php
/**
 * @noinspection PhpUnhandledExceptionInspection
 * @data {
 *   "title" : {
 *       "es" : "Artículos",
 *       "en" : "Posts"
 *   },
 *   "description" : {
 *     "es" : "Algunos artículos sobre programación y otros temas. No esperen nada muy elaborado."
 *   }
 * }
 * @var $this \edwrodrig\site\theme\TemplatePage
 */

use edwrodrig\site\theme\PostLink;

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=$this->getTitle()?></h1>
        </header>
        <hr>
        <div class="flex-column grid-padding">
        <?php foreach ( $this->getRepository()->getPosts() as $post ) : ?>
            <div>
                <?php (new PostLink($post, $this))->html()?>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</div>
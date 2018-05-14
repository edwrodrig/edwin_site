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

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=$this->tr($this->getTitle())?></h1>
        </header>
        <hr>
        <div class="flex-column grid-padding">
        <?php
            foreach ( Site::posts() as $post ) {?>
            <div>
                <?php $post->html_link_box()?>
            </div>
            <?php
            }
        ?>
        </div>
    </div>
</div>
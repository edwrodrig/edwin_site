<?php
/*
 @template \edwrodrig\site\theme\TemplatePage
 @type template
 @data {
    "title" : {
        "es" : "Artículos",
        "en" : "Posts"
    }
}
 */

use edwrodrig\site\Site;

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=Site::tr(Site::page()->get_title())?></h1>
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
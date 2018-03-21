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

use edwrodrig\static_generator\Page;
use edwrodrig\static_generator\Site;

$title = Page::get()->get_title();

?>
<div>
    <div class="section-container container-padding">
        <div class="bigger-font">
            <h1><?=$title?></h1>
            <hr/>
            <div class="layout-column grid-padding">
            <?php
                foreach ( Site::get()->globals['posts'] as $post ) {
                    printf('<a href="%s">%s</a>', $post->get_url(), $post->get_title());
                }
            ?>
            </div>
        </div>
    </div>
</div>
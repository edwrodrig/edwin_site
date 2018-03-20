<?php
/*
 @template \edwrodrig\site\theme\TemplatePage
 @type template
*/

use edwrodrig\static_generator\Site;

?>
<div>
    <div class="section-container container-padding">
    <h1>Artículos</h1>
    <div>
        <?php

        foreach (Site::get()->get_templates('post') as $post ) {
            printf('<a href="%s">%s</a>', $post->get_url(), $post->get_title());
        }
        ?>


    </div>
    </div>
</div>


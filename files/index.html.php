<?php
/*
 @template \edwrodrig\site\theme\TemplatePage
 @type template
 @data {
    "title" : {
        "es" : "Edwin Rodríguez León",
        "en" : "Edwin Rodríguez León"
    }
}
*/

use edwrodrig\static_generator\Site;

?>
<div>
    <div class="section-container container-padding">
        <h1>Artículos</h1>
        <div>
            <?php

            foreach (Site::get()->get_templates('post') as $post ) {
                ?>
                <a href="<?=$post->get_url()?>" class="box-hover">
                    <h2><?=$post->get_title()?></h2>
                    <time><i class="fa fa-clock-o"></i><?=$post->get_date()?></time>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</div>


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
        <div class="ascii-art">
            <pre><?=file_get_contents(__DIR__ . '/../data/photo.txt')?></pre>
        </div>
        <?php $this->social_buttons_bar() ?>
        <h1>Artículos</h1>
        <div>
            <?php

            foreach (Site::get()->globals['posts'] as $post ) {
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


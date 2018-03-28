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
            $post_count = 0;
            foreach (Site::get()->globals['posts'] as $post ) {
                if ( ++$post_count > 4 ) break;
                ?>
                <div>
                    <a href="<?=$post->get_url()?>" class="post-box">
                        <h2><?=$post->get_title()?></h2>
                        <time><i class="fa fa-clock-o"></i><?=$post->get_date()?></time>
                    </a>
                </div>
                <?php
            }
            ?>
            <div>
                <a class="button"><?=tr(['es' => 'Más articulos', 'en' => 'More articles' )?></a>
            </div>
        </div>
    </div>
</div>


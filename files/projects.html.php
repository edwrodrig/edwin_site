<?php
/*
 @template \edwrodrig\site\theme\TemplatePage
 @type template
 @data {
    "title" : {
        "es" : "Proyectos",
        "en" : "Projects"
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
                foreach ( Site::get()->get_templates('post') as $post ) {
                    ?>
                    <a href="<?=$post->get_url()?>" class="box-hover" style="overflow:hidden; text-decoration:none;color:inherit">
                        <div class="layout-row grid-padding">
                            <div class="background-size: cover; background-position: center; background-repeat:no-repeat; width: 100px; height:100px" style="bg-img:image"></div>
                            <div>
                                <h2 style="margin-top:0.2em"><?=$post->get_name()?></h2>
                                <p class="text-justify"><?=$post->get_description()?></p>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

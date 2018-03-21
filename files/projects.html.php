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
                foreach ( Site::get()->globals['projects'] as $project ) {
                    ?>
                    <a href="<?=$project->get_url()?>" class="box-hover" style="overflow:hidden; text-decoration:none;color:inherit">
                        <div class="layout-row grid-padding">
                            <div class="background-size: cover; background-position: center; background-repeat:no-repeat; width: 100px; height:100px" style="background-image:url(<?=$project->get_image()?>"></div>
                            <div>
                                <h2 style="margin-top:0.2em"><?=$project->get_name()?></h2>
                                <p class="text-justify"><?=$project->get_description()?></p>
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

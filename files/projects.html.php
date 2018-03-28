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

use edwrodrig\site\Site;

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=Site::tr(Site::page()->get_title())?></h1>
        </header>
        <hr>
        <div class="grid-padding">
        <?php
            foreach ( Site::projects() as $project ) {?>
            <div>
                <?php Site::html_project_box($project)?>
            </div>
            <?php
            }
        ?>
        </div>
    </div>
</div>

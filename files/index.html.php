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

use edwrodrig\site\Site;

//LOCAL FUNCTIONS

$section_posts = function($max_posts = 4) {?>
    <h1><?=Site::tr(['es' => 'Artículos', 'en' => 'Articles'])?></h1>
    <div class="flex-column grid-padding">
        <?php
        foreach (Site::posts() as $post ) { if ( --$max_posts < 0 ) break;?>
            <div>
                <?php $post->html_link_box()?>
            </div>
            <?php
        }
        ?>
        <div class="align-right">
            <a class="button" href="/posts.html"><?=Site::tr(['es' => 'Más artículos', 'en' => 'More articles'])?></a>
        </div>
    </div>
<?php
};

$section_projects = function($max_projects = 2) {?>
    <h1><?=Site::tr(['es'=> 'Proyectos', 'en' => 'Projects'])?></h1>
    <div class="flex-column grid-padding">
        <?php
        foreach (Site::projects() as $projects ) { if ( --$max_projects < 0 ) break;?>
            <div>
                <?php Site::html_project_box($projects)?>
            </div>
            <?php
        }
        ?>
        <div class="align-right">
            <a class="button" href="/projects.html"><?=Site::tr(['es' => 'Más proyectos', 'en' => 'More projects'])?></a>
        </div>
    </div>
    <?php
};


//CONTENT
?>
<div>
    <div class="section-container container-padding">
        <div class="ascii-art">
            <pre><?=file_get_contents(__DIR__ . '/../data/photo.txt')?></pre>
        </div>
        <?php $this->social_buttons_bar() ?>
        <?php $section_posts(4) ?>
        <hr>
        <?php $section_projects(2)?>
    </div>
</div>


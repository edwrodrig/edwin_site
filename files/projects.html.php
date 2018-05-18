<?php
/**
 * @noinspection PhpUnhandledExceptionInspection
 * @template
 * @data {
 *   "title" : {
 *       "es" : "Proyectos",
 *       "en" : "Projects"
 *   }
 * }
 * @var $this \edwrodrig\site\theme\TemplatePage
 */


use edwrodrig\site\data\Repository;
use edwrodrig\site\theme\ProjectBox;

?>
<div>
    <div class="section-container container-padding">
        <header class="section-header">
            <h1><?=$this->getTitle()?></h1>
        </header>
        <hr>
        <div class="flex-column grid-padding">
        <?php foreach ( Repository::get($this)->getProjects() as $project ) :?>
            <div>
                <?php (new ProjectBox($project, $this))->html() ?>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</div>

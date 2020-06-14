<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPage;
use edwrodrig\mypage\site\BlockProjectBox;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Proyectos",
    'description' => "Proyectos que he programado laboralmente o por amor al arte"
]);

$BLOCK = new BlockPage($page);
$BLOCK->sectionBeginBodyContent()
?>
    <div>
        <div class="section-container container-padding">
            <header class="section-header">
                <h1><?=$BLOCK->getTitle()?></h1>
            </header>
            <hr>
            <div class="flex-column grid-padding">
            <?php foreach ( $BLOCK->getRepository()->getProjects() as $project ) : ?>
                <div>
                    <?php (new BlockProjectBox($page, $project))->html() ?>
                </div>
            <?php endforeach ?>
            </div>
        </div>
    </div>
<?php
$BLOCK->html();
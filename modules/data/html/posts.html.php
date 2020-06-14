<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPage;
use edwrodrig\mypage\site\BlockPostLink;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Artículos",
    'description' => "Algunos artículos sobre programación y otros temas. No esperen nada muy elaborado"
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
        <?php foreach ( $BLOCK->getRepository()->getPosts() as $post ) : ?>
            <div>
                <?php (new BlockPostLink($page, $post))->html()?>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</div>
<?php
$BLOCK->html();
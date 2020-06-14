<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPage;
use edwrodrig\mypage\site\BlockPostLink;
use edwrodrig\mypage\site\BlockProjectBox;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Edwin Rodríguez",
    'description' => "Programador chileno. PHP, C++, Qt5 y otras cosas"
]);

$BLOCK = new BlockPage($page);

$posts = array_slice($BLOCK->getRepository()->getPosts(), 0, 4);
$projects = array_slice($BLOCK->getRepository()->getProjects(), 0, 2);

$BLOCK->sectionBeginBodyContent()
?>
    <div>
        <div class="section-container container-padding">
            <div class="ascii-art">
                <pre><?=file_get_contents(__DIR__ . '/../../data/photo.txt')?></pre>
            </div>
            <?php $BLOCK->htmlSocialButtonBar()?>
            <h1>Artículos</h1>
            <div class="flex-column grid-padding">
                <?php foreach ( $posts as $post ) : ?>
                    <div>
                        <?php (new BlockPostLink($page, $post))->html()?>
                    </div>
                <?php endforeach ?>
                <div class="align-right">
                    <a class="button" href="<?=$BLOCK->url('posts.html')?>">Más artículos</a>
                </div>
            </div>
            <hr>
            <h1>Proyectos</h1>
            <div class="flex-column grid-padding">
                <?php foreach ( $projects  as $project ) :?>
                    <div>
                        <?php (new BlockProjectBox($page, $project))->html()?>
                    </div>
                <?php endforeach ?>
                <div class="align-right">
                    <a class="button" href="<?=$BLOCK->url('projects.html')?>">Más proyectos</a>
                </div>
            </div>
        </div>
    </div>
<?php
$BLOCK->html();


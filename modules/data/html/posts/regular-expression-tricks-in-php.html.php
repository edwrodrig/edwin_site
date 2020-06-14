<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPagePost;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Trucos de expresiones regulare en php",
    'description' => 'En este artículo una serie de trucos de expresiones regulares comunes usando php',
    'publication_date' => "2017-01-31",
    'type' => 'post'
]);


$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<h2>Capturar una contenido entre string</h2>
<pre>
<?=htmlentities(<<<'EOF'
$needle = '/<div class="list-group">(.+)<\/div>/s';

if ( preg_match($needle, $haysack, $matches) ) {
  $between = $matches[1];
}
EOF
)?>
</pre>

<h2>Capturar todos las coincidencias</h2>
<pre>
<?=htmlentities(<<<'EOF'
$needle = '/<a href="(.+)" class=".+" title="(.+)" style/';

if ( preg_match_all($needle, $haysack, $matches, PREG_SET_ORDER) ) {
  foreach ( $matches as $m ) {
    $href = $m[1];
    $title= $m[2];
  }
}
EOF
)
?>
</pre>
<?php
$BLOCK->html();


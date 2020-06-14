<?php
declare(strict_types=1);
/**
 * @var labo86\staty_core\PagePhp $page
 */

use edwrodrig\mypage\site\BlockPagePost;

$page->prepareMetadata([
    'title' => "Parámetros origen destino en funciones de PHP",
    'publication_date' => "2016-12-30",
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<style>
.hay { background-color: #8B0000; }
.nee { background-color: #00008B; }
</style>

<pre>
<a href="http://php.net/manual/es/function.strpos.php">mixed strpos ( <span class="hay">string $haystack</span> , <span class="nee">mixed $needle</span> [, int $offset = 0 ] )</a>
<a href="http://php.net/manual/en/function.in-array.php">bool in_array ( <span class="nee">mixed $needle</span> , <span class="hay">array $haystack</span> [, bool $strict = FALSE ] )</a>
<a href="http://php.net/manual/en/function.str-replace.php">str_replace ( <span class="nee">mixed $search</span> , mixed $replace , <span class="hay">mixed $subject</span> [, int &$count ] )</a>
</pre>
<?php
$BLOCK->html();
<?php
declare(strict_types=1);
/**
 * @var labo86\staty_core\PagePhp $page
 */

use edwrodrig\mypage\site\BlockPagePost;

$page->prepareMetadata([
    'title' => "Obtener el archivo y la linea de una llamada de función en PHP",
    'publication_date' => "2017-02-01",
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<p>There is the code</p>

<pre>
function hola() {
  var_dump(debug_backtrace()[0]);
}

function chao() {
  hola();
}

chao();
</pre>

<p>The output</p>

<pre>
array(4) {
  ["file"]=>
  string(20) "/home/edwin/hola.php"
  ["line"]=>
  int(8)
  ["function"]=>
  string(4) "hola"
  ["args"]=>
  array(0) {
  }
}
</pre>
<?php
$BLOCK->html();

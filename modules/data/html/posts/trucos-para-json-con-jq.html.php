<?php
declare(strict_types=1);
/**
 * @var labo86\staty_core\PagePhp $page
 */

use edwrodrig\mypage\site\BlockPagePost;

$page->prepareMetadata([
    'title' => "Trucos para json con jq",
    'description' => "Funciones recurrentes de formateo y manejo de json usando jq",
    'publication_date' => "2016-12-30",
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
?>
<h2>Probar sintaxis</h2>
<p>Imprime el <code>json</code> sangrado con colores. Este comando falla cuando el <code>json</code> no tiene el formato correcto, lo que lo hace ideal para probar la sintaxis.</p>
<pre>jq . <b>file.json</b></pre>

<h2>Sangrar el json y volcarlo a un archivo</h2>
<p>Simplemente debes usar el comando anterior volcando la salida a un archivo.</p>
<pre>jq . <b>source</b> > <b>target</b></pre>
<?php
$BLOCK->html();
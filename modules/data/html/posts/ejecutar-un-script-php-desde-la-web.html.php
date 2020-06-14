<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPagePost;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Ejecutar script PHP desde la web",
    'description' => "Comando para poder ejecutar un script PHP que esta disponible por una URL",
    'publication_date' => "2017-05-12",
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<p>En ocasiones necesito pasar a algunas personas un pequeño script que haga una función especifica.
Lo que hacía en tales ocasiones era enviarle dicho script por mail.
Pero comunmente ese script no funcionaba en la primera ocasión por diferencias en la máquina o en el caso que funcionará, necesitaban una pequeña función adicional.
Cualquiera fuera el caso, tenía que corregir el script y después volverlo a enviar por mail.
Todo sería más facil si se pudiera disponibilizar el script de una forma más adecuada.
Pués encontré una forma más apropiada de hacerlo disponibilizando el script en una URL y ejecutandolo con el siguiente comando:</p>
<pre>php -d allow_url_include=On -r "include('<b>http://path/to/script.php</b>');"</pre>
<p>PHP no te permite correr directamente un script por una URL,
pero podemos hacerlo corriendo directamente código PHP mediante la opción <code>-r</code>,
donde simplemente hacemos un <code>include</code> del script en cuestión.
Adicionalmente necesitamos habilitar la opción <code>allow_url_include</code> ya que por razones de seguridad, PHP no permite incluir URLs.</p>
<?php
$BLOCK->html();
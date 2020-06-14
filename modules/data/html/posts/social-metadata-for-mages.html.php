<?php
declare(strict_types=1);
/**
 * @var labo86\staty_core\PagePhp $page
 */

use edwrodrig\mypage\site\BlockPagePost;

$page->prepareMetadata([
    'title' => "Metadata social para páginas",
    'description' => 'En este artículo es explicado como agregar metadata social a una página html. Esta metadata es usada para mostrar buenas cajas de descripción en redes sociales a la hora de compartir un vínculo',
    'publication_date' => "2014-04-18",
    'type' => 'post'
]);


$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<h2>Código</h2>
<p>Copia el siguiente código en el <code>head</code> de la página html. Debes reemplazar los valores a los apropiados para tu página.</p>

<script src="https://gist.github.com/edwrodrig/39b3fda59d94aececb73.js"></script>

<h2>Herramientas de validación</h2>
<p>A continuación algunos links a las herramientas de validación para los meta tags de las principales redes sociales.</p>

<ul>
<li><a href="https://developers.facebook.com/tools/debug/">Facebook Open Graph</a></li>
<li><a href="https://dev.twitter.com/docs/cards/validation/validator">Twitter Card Validator</a></li>
<li><a href="http://www.google.com/webmasters/tools/richsnippets">Google</a></li>
</ul>

<h2>Notas</h2>
<p>Cuando tu haces un cambio en algún metadato, es recomendable revalidar la página con las herramientas de validación. Si no lo haces, los vínculos posteriores pueden seguir mostrando la información anterior.</p>
<?php
$BLOCK->html();
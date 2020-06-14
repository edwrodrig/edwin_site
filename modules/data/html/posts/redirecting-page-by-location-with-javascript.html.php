<?php
declare(strict_types=1);
/**
 * @var labo86\staty_core\PagePhp $page
 */

use edwrodrig\mypage\site\BlockPagePost;

$page->prepareMetadata([
    'title' => "Redireccionando página según idioma con javascript",
    'publication_date' => "2017-01-31",
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<p>Here is the code</p>
<pre>
<?=htmlentities(<<<'EOF'
<!DOCTYPE html>
<html lang="es">
<head>
<title>Wikipedia redirect</title>
<script>
let language = navigator.language || navigator.browserLanguage;
if ( language.substr(0,2) === 'es' ) window.location = "http://es.wikipedia.org"; 
else window.location = "http://en.wikipedia.org";
</script>
</head>
<body>
</body>
</html>
EOF
)?>
</pre>
<?php
$BLOCK->html();

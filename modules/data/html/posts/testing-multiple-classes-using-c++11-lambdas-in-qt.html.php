<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPagePost;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Probando muchas clases usando lambdas en Qt",
    'description' => 'En este artículo es explicado una alternativa para organizar tus pruebas unitarias en un solo archivo usando funciones lambda',
    'publication_date' => "2014-05-05",
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<p>Me parece problemático organizar mis pruebas unitarias de QT en muchas clases. Algunas macros como <code>QTEST_APPLESS_MAIN</code> te obliga a tener un proyecto por clase de prueba unitaria, lo que puede convertirse en un dolor de cabeza. Si tu estas usando c++11, puedes aprovechar las funciones lambdas para lidiar fácilmente con este problema.</p>

<h2>Código</h2>

<p>La magia:
<script src="https://gist.github.com/edwrodrig/5c84af39bc151f4cd815.js?file=%20qt_test_main_lambda.cpp"></script>
</p>

<h2>Soluciones alternativas</h2>

<p>Si no te gusta mi solución, prueba con estas alternativas:

<ul>
<li><a href="http://stackoverflow.com/questions/12194256/qt-how-to-organize-unit-test-with-more-than-one-class">Incluyendo todo</a></li>
<li><a href="http://qtcreator.blogspot.com/2009/10/running-multiple-unit-tests.html">Usando una librería</a></li>
</ul>
<?php
$BLOCK->html();
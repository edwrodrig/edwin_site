<?php
/*
@template \edwrodrig\site\theme\TemplatePost
@type template
@data
{
  "title" : { "en" :"Traverse directories on PHP","es" : "Recorrer directorios en PHP" },
  "description": { "en" : "Diferent ways to traverse directories on php", "es" : "Recorrer directorios en PHP"},
  "date" : "2016-12-23",
  "tags" : [ "php", "english" ]
}
*/
?>
<h2>Iterar archivos excluyendo directorios con puntos</h2>

<pre>
foreach (new DirectoryIterator($dirname) as $file) {
    if($file->isDot()) continue;
    echo $file->getFilename();
}
</pre>

<h2>Iterate filtering by extension</h2>

<pre>
foreach (new DirectoryIterator($dirname) as $file) {
    if($file->getExtension() !== 'exe' ) continue;
    echo $file->getFilename();
}
</pre>

<h2>Recursive Way</h2>

<pre>
foreach ( new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dirname)) as $file ) {
  if ( $file->isFile() )
    $file->getPathname();
  }
</pre>

<p>The <code>$file</code> variable in the iteration is a <code>DirectoryIterator</code> class. See the <a href="http://php.net/manual/es/class.directoryiterator.php">documentation</a> for useful functionalities.
</p>


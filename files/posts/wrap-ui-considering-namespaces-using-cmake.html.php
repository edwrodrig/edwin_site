<?php
/**
 * @data {
 *   "title" : {
 *       "en" :"Wrap UI considering namespace using CMake",
 *       "es" : "Envolver UI considerando namespace usando CMake"
 *  },
 *   "description" : {
 *       "en" : "There is a macro for wrap Qt ui files considering namespace.",
 *       "es" : "Una macro para envolver archivos UI de QT considerando los namespace"
 *   },
 *   "date" : "2014-12-04",
 *   "tags" : [ "qt", "cmake", "english" ]
 * }
 * @var $this \edwrodrig\site\theme\TemplatePost
 */
?>
<p>
It's common to organize code in folders, usually representing namespaces to avoid name clashes. But when using ui Qt files cmake, the <code>qt5_wrap_ui</code> macro only consider filenames ignoring folder path. Ui files with the same name and different folder overlaps in the build dirrectory generating compilation problems. The following code is a replacement of <code>qt5_wrap_ui</code> macro that consider filepath fixing the exposed problem.
</p>

<h2>Code</h2>

<p>The awesome macro:

<script src="https://gist.github.com/edwrodrig/0270beff55a675fa35c4.js"></script>
</p>

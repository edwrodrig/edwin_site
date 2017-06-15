{
  "title" :
  {
    "en" :"Testing multiple classes using c++11 lambdas in Qt",
    "es" : "Probando muchas clases usando lambdas en Qt"
  },
  "description":
  {
    "en" : "In this article is explained an alternative the organize you Qt unit test in one main file using c++11 lambda functions.",
    "es" : "En este articulo es explicado una alternativa para organizar tus pruebas unitarias en un solo archivo usando funciones lambda."
  },
  "date" : "2014-05-05",
  "tags" : [ "qt", "test", "c++11" ]
}
---
<p>Me parece problematico organizar mis pruebas unitarias de QT en muchas clases. Algunas macros como <code>QTEST_APPLESS_MAIN</code> te obliga a tener un proyecto por clase de prueba unitaria, lo que puede convertirse en un dolor de cabeza. Si tu estas usando c++11, puedes aprovechar las funciones lambdas para lidiar fácilmente con este problema.</p>

<h2>Código</h2>

<p>La magia:
<script src="https://gist.github.com/edwrodrig/5c84af39bc151f4cd815.js?file=%20qt_test_main_lambda.cpp"></script>
</p>

<h2>Soluciones alternativas</h2>

<p>Si no te gusta mi soluación, prueba con estas alternativas:

<ul>
<li><a href="http://stackoverflow.com/questions/12194256/qt-how-to-organize-unit-test-with-more-than-one-class">Incluyendo todo</a></li>
<li><a href="http://qtcreator.blogspot.com/2009/10/running-multiple-unit-tests.html">Usando una librería</a></li>
</ul>

</p>

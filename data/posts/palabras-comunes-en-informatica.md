{
    "title": {
        "en": "Common computing words",
        "es": "Palabras comunes en informática"
    },
    "description": {
        "en": "Common computing words",
        "es": "Apuntes para el curso de informatica y programación dictado para el Instituto Milenio de Oceanografía"
    },
    "date": "2017-05-15",
    "tags": []
}
---
<h2>Conceptos generales</h2>
<ul>
<li>bit: Un 0 o un 1</li>
<li>byte: 8 bits</li>
<li>CPU: Central Processing Unit, Unidad central de procesamiento</li>
<li>RAM: Random Access Memory, Memoria de acceso aleatorio</li>
<li>LAN: Local Area Network, Red de area local</li>
<li>WAN: Wide Area Network, Red de area amplia</li>
<li>pixel: Picture element, Elemento de imagen</li>
</ul>

<h2>Ejemplos de condicionales</h2>

<pre>
if ( condición ) {
  //cuando se cumple la condición
}
</pre>

<pre>
if ( condición ) {
  //cuando se cumple la condición
} else {
  //en caso contrario
}
</pre>


<pre>
if ( condición_1 ) {
  //cuando se cumple la condición_1
} else if ( condición_2 ) {
  //cuando no se cumple la condición_1 y se cumple la condición_2
} 
</pre>


<pre>
if ( condición_1 ) {
  //cuando se cumple la condición_1
} else if ( condición_2 ) {
  //cuando no se cumple la condición_1 y se cumple la codición_2
} else if ( condición_3 ) {
  //cuando no se cumple la condición_1 ni la condición_2 y se cumple la condición_3
}
...
} else if ( condición_n ) {
  //cuando no se cumple ninguna de las condiciones anteriores y se cumple la condición_n
} else {
  //cuando no se cumple ninguna condición anterior
}
</pre>

<h2>Ejemplos de bucles</h2>

<pre>
while ( condición ) {
  //esto se ejecuta siempre cuando se ejecuta mientras se cumpla la condición
}
</pre>

<p>Bucle infinito</p>
<pre>
while ( true ) {
  //esto se ejecuta siempre
}
</pre>

<p>Bucle que se ejecuta 1000 veces<p>
<pre>
$contador = 0;

while ( $contador < 1000 ) {
  $contador++; 
}
</pre>

<p>Bucle que imprime los números del 1 al 10<p>
<pre>
$contador = 1;

while ( $contador <= 10 ) {
  echo $contador;
  $contador++;
}
</pre>

<p>Bucle que imprime los números del 10 al 1<p>
<pre>
$contador = 10;

while ( $contador >= 1 ) {
  echo $contador;
  $contador--;
}

</pre>



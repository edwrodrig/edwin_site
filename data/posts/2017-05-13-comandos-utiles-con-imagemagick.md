{
    "title": {
        "es": "Comandos \u00fatiles con ImageMagick"
    },
    "description": {
        "es": "Comandos \u00fatiles con ImageMagick"
    },
    "date": "2017-05-13",
    "tags": []
}
---
<p>ImageMagick es el photoshop en línea de comandos. A continuación listaré unos comandos que nos serán útiles a la hora de ciertas manipulaciones de imagenes comunes.</p>

<h2>Cambiar tamaño de imagen</h2>
<pre>convert <b>input.png</b> -resize <b>output.png</b></pre>

<h2>Teñir la imagen de un color</h2>
<pre>convert <b>input.png</b> -fill "<b>#FF0000</b>" -tint 100 <b>output.png</b></pre>
<p>Este comando tiñe la imagen del color especificado.
Teñir funciona solo con los tonos medios, en concreto,
los píxeles blancos quedan blanco y los negros quedan negros.</p>

<h2>Colorizar la imagen</h2>
<pre>convert <b>input.png</b> -matte -fill "<b>#00FF00</b>" -colorize 100  <b>output.png</b></pre>
<p>Este comando deja la imagen como una sombra de un solo color sin medio tonos.
Todos los píxeles son transformados al color pero manteniendo la transparencia.</p>

<h2>Dar borde a la imagen</h2>
<pre>convert <b>input.png</b> -matte -bordercolor none -border <b>3x3</b> <b>output.png</b></pre>

<h2>Brillo externo</h2>
<pre>convert <b>input.png</b> -matte -bordercolor none -border <b>20x20</b> <b>temp_base.png</b>
convert <b>temp_base.png</b> -matte -fill "white" -colorize 100 -blur <b>20x20</b> <b>temp_glow.png</b>
convert <b>temp_glow.png</b> <b>temp_base.png</b> -compose Over -composite <b>output.png</b>
</pre>

<h2>Convertir imagen SVG a PNG con inkscape</h2>
<pre>inkscape -D --export-png=<b>output.png</b> -w <b>800</b> -h <b>100</b> <b>input.svg</b></pre>
<p>Donde <code>-w</code> es el ancho de la imagen y <code>-h</code> es el alto, en píxeles.
Si se omite alguno de los dos argumentos anteriores, se deduce el otro tal que se conserve la razón de aspecto.
Se distorcionará la imagen de salida, si los valores introducidos no corresponden a la razón de aspecto.</p>

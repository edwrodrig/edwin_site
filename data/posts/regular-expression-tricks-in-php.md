{
  "title": {
    "en" : "Regular expression tricks in php",
    "es" : "Trucos de expresiones reguales en php"
  },
  "description": {
    "es": "En este artículo una serie de trucos de expresiones regulares comunes usando php" 
  },
  "date": "2017-01-31",
  "tags": ["php", "regex"]
}
---
<h2>Capturar una contenido entre string</h2>
<pre>
<?=htmlentities(<<<'EOF'
$needle = '/<div class="list-group">(.+)<\/div>/s';

if ( preg_match($needle, $haysack, $matches) ) {
  $between = $matches[1];
}
EOF
)?>
</pre>

<h2>Capturar todos las coincidencias</h2>
<pre>
<?=htmlentities(<<<'EOF'
$needle = '/<a href="(.+)" class=".+" title="(.+)" style/';

if ( preg_match_all($needle, $haysack, $matches, PREG_SET_ORDER) ) {
  foreach ( $matches as $m ) {
    $href = $m[1];
    $title= $m[2];
  }
}
EOF
)
?>
</pre>


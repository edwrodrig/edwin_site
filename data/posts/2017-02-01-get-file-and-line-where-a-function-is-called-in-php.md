{
    "title": {
        "en": "Get file and line where a function is called in php"
    },
    "description": {
        "en": "Get file and line where a function is called in php"
    },
    "date": "2017-02-01",
    "tags": []
}
---
<p>There is the code</p>

<pre>
function hola() {
  var_dump(debug_backtrace()[0]);
}

function chao() {
  hola();
}

chao();
</pre>

<p>The output</p>

<pre>
array(4) {
  ["file"]=>
  string(20) "/home/edwin/hola.php"
  ["line"]=>
  int(8)
  ["function"]=>
  string(4) "hola"
  ["args"]=>
  array(0) {
  }
}
</pre>

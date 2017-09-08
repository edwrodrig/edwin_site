{
    "title": {
        "en": "Redirecting page by location with javascript"
    },
    "description": {
        "en": "Redirecting page by location with javascript"
    },
    "date": "2017-01-31",
    "tags": []
}
---
<p>Here is the code</p>
<pre>
<?=htmlentities(<<<'EOF'
<!DOCTYPE html>
<html>
<head>
<title>Wikipedia redirect</title>
<script>
var language = navigator.language || navigator.browserLanguage;
if ( language.substr(0,2) == 'es' ) window.location = "http://es.wikipedia.org"; 
else window.location = "http://en.wikipedia.org";
</script>
</head>
<body>
</body>
</html>
EOF
)?>
</pre>

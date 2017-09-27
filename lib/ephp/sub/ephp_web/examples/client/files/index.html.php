<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<textarea style="width:100%;height:100px" id="json">{"key": "value"}</textarea>
<br/>
<button type="button" onclick="CLIENT_DEMO.request(JSON.parse(document.getElementById('json').value))">Submit</button>
<?php echo (new Client)() ?>
<br/>
<br/>
<form id="form">
<input type="text" name="k1" />
<input type="text" name="k2" />
<button type="button" onclick='CLIENT_DEMO.request(CLIENT_DEMO.form_to_json("form"))'>Submit form</button>
</form>
</body>
</html>

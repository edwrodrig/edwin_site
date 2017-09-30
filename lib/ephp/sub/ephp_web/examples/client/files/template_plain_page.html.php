<?php
(new class extends \ephp\web\TemplatePage {

function body($content = '') {?>
<h1>Hola</h1>
<p>Como te va</p>
<?php
}

})->print();

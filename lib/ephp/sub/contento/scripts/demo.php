<?php

passthru('rm -rf contento');
mkdir('contento');
chdir('contento');
passthru('git clone https://github.com/edwrodrig/contento.git');
mkdir('data');
mkdir('www');
copy('contento/scripts/files/config.json', 'data/config.json');
copy('contento/scripts/files/contento.php', 'www/contento.php');
passthru('cp -Rf contento/scripts/files/types data/');
passthru('mv contento src');
passthru('php www/contento.php configure');
passthru('php www/contento.php contento_collection_set');




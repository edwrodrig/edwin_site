<?php

passthru('rm -rf ephp_usac');
mkdir('ephp_usac');
chdir('ephp_usac');
passthru('git clone https://github.com/edwrodrig/ephp_usac.git');
mkdir('data');
mkdir('www');
copy('ephp_usac/scripts/files/config.json', 'data/config.json');
copy('ephp_usac/scripts/files/usac.php', 'www/usac.php');
passthru('mv ephp_usac src');
passthru('php www/usac.php configure');




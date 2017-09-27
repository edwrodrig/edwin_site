<?php

passthru('rm -rf demo_ephp_mvc');
mkdir('demo_ephp_mvc');
chdir('demo_ephp_mvc');
passthru('git clone https://github.com/edwrodrig/ephp_mvc.git');
copy('ephp_mvc/scripts/files/demo.php', 'index.php');


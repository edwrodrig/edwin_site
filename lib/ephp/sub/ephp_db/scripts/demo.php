<?php

passthru('rm -rf demo');
mkdir('demo');
chdir('demo');
passthru('git clone https://github.com/edwrodrig/ephp_db.git');
copy('ephp_db/scripts/files/demo_script.php', 'RUNME.php');


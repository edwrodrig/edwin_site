<?php

passthru('rm -rf ephp_db');
passthru('git clone https://github.com/edwrodrig/ephp_db.git');
chdir('ephp_db');
passthru('rm -rf examples LICENSE README.md scripts test .git');

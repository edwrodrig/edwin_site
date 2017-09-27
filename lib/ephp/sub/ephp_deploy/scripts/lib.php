<?php

passthru('rm -rf ephp_deploy');
passthru('git clone https://github.com/edwrodrig/ephp_deploy.git');
chdir('ephp_deploy');
passthru('rm -rf examples LICENSE README.md scripts test .git');

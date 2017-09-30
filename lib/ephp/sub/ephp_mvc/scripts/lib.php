<?php

passthru('rm -rf ephp_mvc');
passthru('git clone https://github.com/edwrodrig/ephp_mvc.git');
chdir('ephp_mvc');
passthru('rm -rf examples LICENSE README.md scripts test .git');

<?php

passthru('rm -rf ephp_usac');
passthru('git clone https://github.com/edwrodrig/ephp_usac.git');
chdir('ephp_usac');
passthru('rm -rf examples LICENSE README.md scripts test sub .git');

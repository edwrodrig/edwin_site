<?php

passthru('rm -rf ephp_tokac');
passthru('git clone https://github.com/edwrodrig/ephp_tokac.git');
chdir('ephp_tokac');
passthru('rm -rf examples LICENSE README.md scripts test sub .git');

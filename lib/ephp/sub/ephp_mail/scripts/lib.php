<?php

passthru('rm -rf ephp_mail');
passthru('git clone https://github.com/edwrodrig/ephp_mail.git');
chdir('ephp_mail');
passthru('rm -rf examples LICENSE README.md scripts test .git');

<?php

passthru('rm -rf ephp');
passthru('git clone https://github.com/edwrodrig/ephp.git');
chdir('ephp');
passthru('rm -rf .git*');

<?php

passthru('rm -rf contento_type contento');
passthru('git clone https://github.com/edwrodrig/contento.git');
passthru('mv contento/sub/contento_type .');
passthru('rm -rf contento');




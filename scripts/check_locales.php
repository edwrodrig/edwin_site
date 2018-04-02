<?php

function check_lang($lang) {
    static $langs = null;
    if ( is_null($langs) ) {
        $langs = explode("\n", shell_exec('locale -a'));
    }
    echo "Checking lang[$lang]...";
    if ( !in_array($lang, $langs) ) {
        echo "NOT AVAILABLE\n";
        exit(1);
    } else {
        echo "AVAILABLE\n";
    }
}

check_lang ('es_CL.utf8');


exit(0);
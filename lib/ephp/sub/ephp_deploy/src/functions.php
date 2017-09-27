<?php
namespace ephp\deploy;

function c($command, $error_message) {
  passthru($command, $r);
  if ( $r > 0 ) {
    throw new \Exception($error_message);
  }
}



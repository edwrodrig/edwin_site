<?php

namespace contento;

class TypeUpdater {

public $target;

function __construct($target) {
  $this->target = $target;
}

function __invoke(...$files) {
  foreach ( $files as $file ) {
    copy( __DIR__ . '/../files/types/' . $file, $this->target . '/' . basename($file));
  }
}

}

<?php
namespace ephp\deploy;

class Copy {

public $target;
public $source = 'output';

public function __invoke() {
  echo "DEPLOYING throught COPY\n";
  echo "Uploading files...\n";
  \ephp\Util::call(sprintf('cp -Rf %s/* %s', $this->source, $this->target), "Error copying output [$this->source] to [$this->target]");
  echo "SITE DEPLOYED\n";

}

};



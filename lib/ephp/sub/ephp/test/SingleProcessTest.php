<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');


class SingleProcessTest extends TestCase {

function testNoOffset() {
  \ephp\SingleProcess::create('php -r ' . escapeshellarg('for($i = 0; $i < 10; $i++ ) {echo $i, "\n"; usleep(500000);}'))->launch();
}


}

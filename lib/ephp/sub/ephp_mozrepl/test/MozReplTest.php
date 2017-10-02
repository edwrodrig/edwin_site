<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class MozReplTest extends TestCase {

function testSend() {
  $this->assertEquals("ASDF", strtoupper("asdf"));
}

}

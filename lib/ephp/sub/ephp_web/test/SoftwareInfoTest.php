<?php
require_once(__DIR__ . '/../include.php');
use PHPUnit\Framework\TestCase;
use ephp\web\SoftwareInfo;

class SoftwareInfoTest extends TestCase {

function testType() {
  $b = (new \ephp\web\Builder);
  $b->lang = 'en';
  $this->assertEquals('apple disk image', \ephp\web\SoftwareInfo::type_description(['type' => 'dmg' ,'os' => 'osx']));
}


}


<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\tokac\Loader;

class LoaderTest extends TestCase {


/**
 * @runInSeparateProcess
 */
function testLoader() {
  $l = new class extends Loader {
    function console() {
      $this->tokac->pdo = \ephp\db\Db::sqlite();
      $this->init_tokac();
    }
  };

  ob_start();
  $l();
  $result = ob_get_clean();

  $this->assertEquals("Available commands:\n  help                                 Show help\n\n", $result);
}

}

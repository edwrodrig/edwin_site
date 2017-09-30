<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

use ephp\mvc\Request;

class RequestTest extends TestCase {

function paramsProvider() {
return [
[
  ['a' => 'da', 'b' => 'db', 'c' => 'dc'],
  []
],
[
  ['a' => '1', 'b' => 'db', 'c' => 'dc'],
  ['1']
],
[
  ['a' => '1', 'b' => '2', 'c' => 'dc'],
  ['1', '2']
],
[
  ['a' => '1', 'b' => '2', 'c' => '3'],
  ['1', '2', '3']
],
[
  ['a' => '1', 'b' => 'db', 'c' => 'dc'],
  ['a' => '1']
],
[ 
  ['a' => 'da', 'b' => '1', 'c' => 'dc'],
  ['b' => '1']
],
[
  ['a' => 'da', 'b' => 'db', 'c' => 'dc'],
  ['e' => '1']
] 


];

}

/**
 * @dataProvider paramsProvider
 */
function testParams($expected, $params) {
  $c = new class {
    function func($a = 'da', $b = 'db', $c = 'dc') {
      return '1';
    }
  };

  $class = new \ReflectionClass($c);
  $method = $class->getMethod('func');
  
  $params = Request::params($method, $params);
  $this->assertEquals($expected, $params);
}

function testParams2() {
  $c = new class {
    function func($a = 'da', $b) {
      return '1';
    }
  };

  $class = new \ReflectionClass($c);
  $method = $class->getMethod('func');

  $params = ['b' => '1'];
  $expected = ['a' => 'da', 'b' => '1'];
  $this->assertEquals($expected, Request::params($method, $params));

  try {
    Request::params($method, []);
    $this->assertTrue(false, 'should throw');
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_PARAM_MISSING', $e->getMessage()); 
    $this->assertEquals('b', $e->desc);
  }
}

function testParams3() {
  $c = new class {
    function func($session, string $collection, bool $short = true) {
      return '1';
    }
  };

  $class = new \ReflectionClass($c);
  $method = $class->getMethod('func');

  $params = ['session' => 'a', 'collection' => 'b'];
  $expected = ['session' => 'a', 'collection' => 'b', 'short' => true];
  $this->assertEquals($expected, Request::params($method, $params));

}


function testInvokeAction() {
  $c = new Request;

  try {
    $c->invoke_action('any_action', []);
    $this->assertTrue(false, 'should throw');
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_AVAILABLE', $e->getMessage());
  }
}

function testInvokeAction2() {
  $c = new Request;
  $c->add_action(new class {});

  try {
    $c->invoke_action(null, []);
    $this->assertTrue(false, 'should throw');
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_SPECIFIED', $e->getMessage());
  }
}

function testInvokeAction3() {
  $c = new Request;
  $c->add_action(new class {
    function hola() {}
  });

  try {
    $c->invoke_action('hola2', []);
    $this->assertTrue(false, 'should throw');
  } catch ( \Exception $e ) {
    $this->assertEquals('ACTION_NOT_AVAILABLE', $e->getMessage());
  }
}

function testInvokeActionSuccess() {
  $c = new Request;
  $c->add_action(new class {
    function hola($a) { return $a + 1; }
  });

  $r = $c->invoke_action('hola', [1]);
  $this->assertEquals(2, $r);
}

function testInvokeActionSuccessMultiple() {
  $c = new Request;
  $c->add_action(
    new class {
      function hola($a) { return $a + 1; }
    },
    new class {
      function hola2($a) { return $a + 2; }
    }
  );

  $r = $c->invoke_action('hola', [1]);
  $this->assertEquals(2, $r);

  $r = $c->invoke_action('hola2', [1]);
  $this->assertEquals(3, $r);
}

function testInvokeActionPrecedence() {
  $c = new Request;
  $c->add_action(
    new class {
      function hola($a) { return $a + 1; }
    },
    new class {
      function hola($a) { return $a + 2; }
    }
  );

  $r = $c->invoke_action('hola', [1]);
  $this->assertEquals(2, $r);

  $c->add_action(
    new class {
      function hola($a) { return $a + 3; }
    }
  );

  $r = $c->invoke_action('hola', [1]);
  $this->assertEquals(4, $r);

}


function testInvokeActionSuccessFilter() {
  $c = new Request;
  $c->add_action(new class {
    function hola($a) { return $a + 1; }
  });
  $c->add_filter(new class {
    function __invoke($a) { $a['a'] += 100; return $a; }
  });

  $r = $c->invoke_action('hola', [1]);
  $this->assertEquals(102, $r);
}

function testGetActionMethod() {
  $c = new class {
    function hola() {}
    function filter() {}
    private function chao() {}
  };

  $this->assertInstanceOf(\ReflectionMethod::class, Request::get_object_method($c, 'hola'));
  $this->assertInstanceOf(\ReflectionMethod::class, Request::get_object_method($c, 'filter'));
  $this->assertNull(Request::get_object_method($c, 'chao'));
  $this->assertNull(Request::get_object_method($c, 'hola_como_te_va'));
}

}



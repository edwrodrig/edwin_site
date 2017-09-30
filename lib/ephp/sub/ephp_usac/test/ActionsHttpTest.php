<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class ActionsHttpTest extends TestCase {

static public $db;
static public $model;
static public $actions;
static public $filter;

public static function setUpBeforeClass()
{
  self::$db = new \ephp\usac\Db();
  self::$model = new \ephp\usac\Model();
  self::$model->db = self::$db;
  self::$actions = new \ephp\usac\ActionsHttp();
  self::$actions->usac_model = self::$model;
  self::$filter = new \ephp\usac\FilterSession();
  self::$filter->usac_model = self::$model;
}

function setUp() {
  self::$db->pdo = \ephp\db\Db::sqlite();
  self::$db->create();
}

function testDbCreateUser() {
  self::$db->call('user_create', 'edwin', 'pass', 'edwin@mail.com', 1);

  $this->assertEquals([['id' => 1, 'password' => 'pass', 'status' => 0, 'name' => 'edwin', 'mail' => 'edwin@mail.com', 'session' => null, 'type' => 1]], self::$db->call('user_by_name', 'edwin')->fetchAll(\PDO::FETCH_ASSOC));
}

function testCreateUser() {
  self::$model->user_create('edwin', 'pass', 'edwin@mail.com', 1);
  
  $session = self::$actions->user_login('edwin', 'pass')['session'];
  
  $this->assertInternalType('string', $session);

  $this->assertEquals(['id' => 1, 'name' => 'edwin', 'session' => $session, 'status' => 0, 'type' => 1], self::$model->user_by_session($session));

  $router = new \ephp\mvc\RequestAssoc();
  $router->add_action(self::$actions);
  $router->add_filter(self::$filter);

  $this->assertEquals(true, $router(['action' => 'session_check', 'session' => $session]));

  $router(['action' => 'session_logout', 'session' => $session]); 

  $this->assertEquals(FALSE, self::$model->user_by_session($session));
}

function testNoLoginGuestUser() {
  $session = self::$actions->user_login_guest()['session'];
  $this->assertInternalType('string', $session);

  $user = self::$model->user_by_session($session);
  $this->assertEquals(\ephp\usac\Model::USER_TYPE_GUEST, $user['type']);
  $this->assertEquals(0, strpos($user['name'], 'guest_'));

  try {
    self::$actions->user_login($user['name'], '');
    $this->assertTrue(false);
  } catch ( \Exception $e ) {
    $this->assertEquals("USER_NOT_EXISTS", $e->getMessage());
  }
}

function testSessionInvalid() {
  $router = new \ephp\mvc\RequestAssoc();
  $router->add_action(self::$actions);
  $router->add_filter(self::$filter);

  try {
     $router(['action' => 'session_check', 'session' => 'adfasdfa']);
     $this->assertTrue(false,'should except');
  } catch ( \Exception $e ) {
    $this->assertEquals('SESSION_INVALID', $e->getMessage());
    $this->assertEquals(2003, $e->getCode());
  }

}

function testRelogin() {
  self::$model->user_create('edwin', 'pass', 'edwin@mail.com');
  $session = self::$actions->user_login('edwin', 'pass');


  $this->assertEquals($session, self::$actions->user_login('edwin', 'pass'));
}

}

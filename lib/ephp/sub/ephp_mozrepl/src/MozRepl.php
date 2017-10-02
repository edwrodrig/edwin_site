<?php

namespace ephp\mozrepl;

class MozRepl {

public $socket;

function __construct($address = '127.0.0.1', $port = 4242) {
  $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  if ( socket_connect($this->socket, $address, $port) === FALSE ) {
    echo 'failure';
  }
  $this->read();
  $this(sprintf("repl.load('file://%s')", __DIR__ . '/mozrepl/interactor.js'));
  $this("repl.pushInteractor('ephp')");
}

function read() {
  $output = '';
  while ( $buf = socket_read($this->socket, 5000, PHP_BINARY_READ) ) {
    $output .= $buf;
    if ( substr($output, -2) === "> " ) break;
  }
  $output = explode("\n", $output);
  array_pop($output);
  return implode("\n", $output);
}

function __invoke($command) {
  echo "command : [$command]\n";
  $ret = '';
  if ( socket_write($this->socket, $command . "\n", 32768) ) {
    $ret = $this->read();
  }
  if ( strpos($ret, "!!!") === 0 ) { throw 'Error'; }
  echo "result : [$ret]\n";
  return $ret;
}

function load($url) {
  $this("url $url");
  $this->wait();
}

function wait($location = '') {
  if ( !empty($location) ) {
    //while ( $this->current_url() === $location ) { usleep(500000); }
  }
  do {
    usleep(500000);
  } while ( $this('is_ready') !== 'true' );
}

function selector($id) {
  foreach ( $id as $key => $value ) {
    return "$key $value";
  }
  return "";
}

function click_while($id) {
  while ( $this->click($id) !== 'true' ) { usleep(500000);}
}

function click($id) {
  return $this("click ". $this->selector($id));
}

function change($id) {
  return $this("change ". $this->selector($id));
}

function click_pos($x, $y) {
  return $this("click_pos $x $y");
}

function set($id, $value) {
  $this("set " . $this->selector($id) . " " . str_replace(' ','+1*2#3-4_5',$value));
}

function get($id) {
  return $this("get " . $this->selector($id));
}

function current_url() {
  return $this("location");
}

function get_while($id) {
  $data = '';
  while ( empty($data) ) {
    usleep(500000);
    $data = $this->get($id);
  }
  usleep(500000);
  return $this->get($id); 
}

function table_while($id) {
  $table = [];
  while ( empty($table) ) {
    usleep(500000);
    $table = $this->table_dump($id);
  }
  usleep(500000);
  return $this->table_dump($id);
}

function table_dump($id) {
  $ret = $this("table " . $this->selector($id));
  return json_decode($ret, true);
} 

function get_a_id($value) {
  $matches;
  if ( preg_match('/<a id="([\w\d_]*)"/', $value, $matches) ) {
    return $matches[1];
  }
  return null;
}

function get_span_content($value) {
  $matches;
  if ( preg_match('/<span id="[\w\d_]*">([^<]*)<\/span>/', $value, $matches) ) {
    return $matches[1];
  }
  return $value;
}

function get_map($id, $map) {
  $value = $this->get($id);
  return $map[$value] ?? $value;
}

}


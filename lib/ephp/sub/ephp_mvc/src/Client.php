<?php

namespace ephp\mvc;

class Client {

private $service;
private $session;

public function __construct($service) {
  $this->service = $service;
}

public function request($data) {
  $context = stream_context_create(['http' =>
    [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => json_encode($data)
    ]
  ]);
  $r = json_decode(file_get_contents($this->service, false, $context), true);
  if ( ($r['status'] ??  -1) >= 0 ) {
    return $r['data'];
  } else {
    ob_start();
    var_dump($r);
    error_log(ob_get_clean());
    throw new \Exception('Request error');
  }
}

}
?>

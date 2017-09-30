<?php

require_once(__DIR__ . '/../../include.php'); 

$client = new \ephp\mvc\Client('http://localhost:8081/json.php');

$response = $client->request([
  'action' => 'user_login',
  'username' => 'edwin',
  'password' => 'edwin'
]);

var_dump($response);

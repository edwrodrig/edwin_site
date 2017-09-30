<?php

require_once(__DIR__ . '/../../include.php'); 

$client = new \ephp\mvc\Client('http://localhost:8081/json.php');

$session = $client->request([
  'action' => 'user_login',
  'username' => 'edwin',
  'password' => 'edwin'
]);


$response = $client->request([
  'action' => 'contento_collection_by' ,
  'session' => $session
]);


var_dump($response);


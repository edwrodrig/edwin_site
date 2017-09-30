<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../include.php');

class SmtpTest extends TestCase {

public static $cred = [
  'username' => 'your_mail@gmail.com',
  'password' => 'your_password',
  'host' => 'ssl://smtp.gmail.com',
  'port' => 465,
];

function testSend() {

  $data = file_get_contents('http://lorempixel.com/400/200/');
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime =  $finfo->buffer($data);
  $message = [
'from' => ['text' => 'Bob Example'],
'to' => ['text' => 'Alice Example', 'mail' => 'edwrodrig@gmail.com'],
'cc' => 'theboss@example.com',
'date' => 'Tue, 15 January 2008 16:02:43 -0500',
'subject' => 'Test message',
'plain' => <<<EOF
Hello Alice.
This is a test message with 5 header fields and 4 lines in the message body.
Your friend,
Bob
EOF
,
 'html' => <<<EOF
<html>
  <head><meta charset="UTF-8"></meta></head>
  <body>
    <h1>Hola</h1>
    <p> Como te va <a href="http://es.imo-chile.cl">Hola</a></p>

  <body>
</html>
EOF
,
'attachments' => [
  [
    'name' => 'cini te va dkfajnajkdsf.txt',
    'type' => 'text/plain',
    'data' => 'adfadfadsf' 
  ],
  [
    'name' => 'image.png',
    'type' => $mime,
    'data' => $data
  ]
  
]
];


  $smtp = new \ephp\mail\Smtp(self::$cred);
  $smtp->send($message);

  $this->assertEquals("S", end($smtp->log)[0]);
  $this->assertTrue(strpos(end($smtp->log)[1], "250") === 0);
}

}

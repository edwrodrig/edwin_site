<?php
namespace ephp\mail;

class Smtp {

public $credentials = [
  'host' => 'ssl://smtp.gmail.com',
  'port' => 465
];

public $log = [];

function __construct($credentials = null) {
  $this->credentials = array_replace($this->credentials, $credentials);
}

public static function mail_str($mail) {
  $boundary  = "NextPart_DC7E1BB5_1105_4DB3_BAE3_2A6208EB099D";
  $boundary2 = "NextPart_DC7E1BB5_1105_4DB3_BAE3_2A6208EB0666";

  $str = [];
  if ( !empty($mail['from']) ) $str[] = sprintf("From: %s", $mail['from']['text']);
  if ( !empty($mail['to']) ) $str[] = sprintf("To: \"%s\" <%s>", $mail['to']['text'], $mail['to']['mail']);
  if ( !empty($mail['cc']) ) $str[] = sprintf("Cc: %s", $mail['cc']);
  if ( !empty($mail['date']) ) $str[] = sprintf("Date: %s", $mail['date']);
  if ( !empty($mail['subject']) ) $str[] = sprintf("Subject: %s", $mail['subject']);
  $str[] = "MIME-Version: 1.0";
  $str[] = sprintf('Content-Type: multipart/mixed; boundary="%s"', $boundary2);
  $str[] = '';
  $str[] = '--' .  $boundary2;
  $str[] = sprintf('Content-Type: multipart/alternative;boundary="%s"', $boundary);
  $str[] = '';
  if ( !empty($mail['plain']) ) {
    $str[] = '--' . $boundary;
    $str[] = 'Content-type: text/plain; charset="utf-8"';
    $str[] = '';
    $str[] = $mail['plain'];
  }
  if ( !empty($mail['html']) ) {
    $str[] = '--' . $boundary;
    $str[] = 'Content-type: text/html; charset="utf-8"';
    $str[] = '';
    $str[] = $mail['html'];
  }
  $str[] = '--' . $boundary .'--';


  foreach ( $mail['attachments'] ?? [] as $att ) {
    $str[] = '--' .  $boundary2;
    $str[] = sprintf('Content-Disposition: attachment; filename=%s', $att['name']);
    $str[] = sprintf('Content-type: %s; name=%s', $att['type'], $att['name']);
    $str[] = 'Content-transfer-encoding: base64';
    $str[] = '';
    $str[] = base64_encode($att['data']);

  }

  $str[] = '--' . $boundary2 . '--';
  $str[] = '.';
  $str[] = '';
  return implode("\r\n", $str);
}

function send($mail) {
  if ( $h = fsockopen($this->credentials['host'], $this->credentials['port'])) {
     $data = [
            0,
            "EHLO edwin.cl",
            'AUTH LOGIN',
            base64_encode($this->credentials['username']),
            base64_encode($this->credentials['password']),
            sprintf("MAIL FROM: <%s>", $this->credentials['username']),
            sprintf("RCPT TO: <%s>", $mail['to']['mail']),
            'DATA',
            self::mail_str($mail)
     ];
     foreach( $data as $c ) {
       $c && fwrite($h, "$c\r\n");
       $this->log[] = ["C", $c];
       do {
         $string = fgets($h, 256);
         $this->log[] = ["S", $string];
       } while(substr($string, 3, 1) != ' ');
     }
     fwrite($h, "QUIT\r\n");
     return fclose($h);
  }
}

}


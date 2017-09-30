<?php
namespace ephp\tokac;

class Error extends \ephp\Error {

const ERR = [
  1000,
  'ENTRY_EXPIRED',
  'ENTRY_NOT_EXISTS'
];

static function fire_if_expired($r) {
  $expiration_date = (new \Datetime($r['creation_date']))->add(\DateInterval::createFromDateString(sprintf('T%sM', $r['duration'])));
  if ( $expiration_date < new \Datetime('now') )
    self::fire('ENTRY_EXPIRED');
}

}


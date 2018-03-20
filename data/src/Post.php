<?php
namespace edwin\data;

class Post extends \ephp\data\Entity {

function link() {
  return sprintf('/post/%s.html', $this['id']);
}

static function compare($a, $b) {
  return $a['date'] <=> $b['date'];
}

}

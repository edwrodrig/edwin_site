<?php
namespace edwin\data;

class Post extends \ephp\data\Entity {

function link() {
  return sprintf('/post/%s.html', $this['id']);
}

static function sort($a, $b) {
  return $b['date'] <=> $a['date'];
}

}

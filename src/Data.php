<?php
namespace {

class Data extends \ephp\data\Data {

public static $Project;
public static $Post;

public static function setPost($data) {
  $data = tr($data);
  usort($data, function($a, $b) { return $b['date'] <=> $a['date']; });
  self::set_map('Post', $data);  
}

}

}

namespace data {

class Post extends \ephp\data\Entity {

function link() {
  return sprintf('/post/%s.html', $this->data['id']);
}

}

}

<?php
namespace ephp\web;

class BoxImage extends Template {

public $container;
public $image;

function __construct(...$args) {
  $this->container = tag([style_def(['display' => 'block', '> *' => style(['size' => '100%'])])], ...$args);
  $this->image = tag();
}

function __invoke() {
  $this->container->open();
  ($this->image)();
  $this->container->close();
}

public static function SocialButton(...$args) {
  return new BoxImage('a', [style_def(['size' => '50px', 'border-radius' => '50%', 'padding' => '10px', 'trans' => ['background-color' => '0.5s']])], ...$args);
}

public static function Facebook(...$args) {
  $b = self::SocialButton([style_def(['background-color' => '#3b5998', ':hover' => style(['background-color' => '#6395ff'])])], ...$args);
  $b->image->set([style_def(['bg_img' => '/assets/images/widget_social_button/facebook.png'])]);
  return $b;
}

public static function Youtube(...$args) {
  $b = self::SocialButton([style_def(['background-color' => '#cc181e', ':hover' => style(['background-color' => '#ff5a5f'])])], ...$args);
  $b->image->set([style_def(['bg_img' => '/assets/images/widget_social_button/youtube.png'])]);
  return $b;
}

public static function Twitter(...$args) {
  $b = self::SocialButton([style_def(['background-color' => '#4099ff', ':hover' => style(['background-color' => '#a0ccff'])])], ...$args);
  $b->image->set([style_def(['bg_img' => '/assets/images/widget_social_button/twitter.png'])]);
  return $b;

}

public static function Phone(...$args) {
  $b = self::SocialButton([style_def(['background-color' => '#000000', ':hover' => style(['background-color' => 'grey'])])], ...$args);
  $b->image->set([style_def(['bg_img' => '/assets/images/widget_social_button/phone.png'])]);
  return $b;

}

public static function Email(...$args) {
  $b = self::SocialButton([style_def(['background-color' => '#000000', ':hover' => style(['background-color' => 'grey'])])], ...$args);
  $b->image->set([style_def(['bg_img' => '/assets/images/widget_social_button/email.png'])]);
  return $b;

}

public static function Address(...$args) {
  $b = self::SocialButton([style_def(['background-color' => '#000000', ':hover' => style(['background-color' => 'grey'])])], ...$args);
  $b->image->set([style_def(['bg_img' => '/assets/images/widget_social_button/address.png'])]);
  return $b;

}
}

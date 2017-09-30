<?php

namespace ephp;

class Image {

static function optimize_jpg($input, $output, $size) {
  if ( !empty($size['h']) && !empty($size['h']) ) {
    $size = $size['w'] . 'x' . $size['h'];
    passthru(sprintf('convert %s -sampling-factor 4:2:0 -strip -resize %s^ -quality 75 -gravity center -extent %s %s', $input, $size, $size, $output));
  } else if ( !empty($size['h']) ) {
    passthru(sprintf('convert %s -sampling-factor 4:2:0 -strip -resize x%s\> -quality 75 %s', $input, $size['h'], $output));
  } else if ( !empty($size['w']) ) {
    passthru(sprintf('convert %s -sampling-factor 4:2:0 -strip -resize %s\> -quality 75 %s', $input, $size['w'], $output));
  } else {
    passthru(sprintf('convert %s -sampling-factor 4:2:0 -strip -quality 75 %s', $input, $output));
  }
}

static function optimize_png($input, $output, $size) {
  if ( !empty($size['h']) && !empty($size['h']) ) {
    $size = $size['w'] . 'x' . $size['h'];
    passthru(sprintf('convert %s -strip -resize %s^ -gravity center -extent %s %s', $input, $size, $size, $output));
  } else if ( !empty($size['h']) ) {
    passthru(sprintf('convert %s -strip -resize x%s\> %s', $input, $size['h'], $output));
  } else if ( !empty($size['w']) ) {
    passthru(sprintf('convert %s -strip -resize %s\> %s', $input, $size['w'], $output));
  } else {
    passthru(sprintf('cp %s %s', $input, $output));
  }
}

}

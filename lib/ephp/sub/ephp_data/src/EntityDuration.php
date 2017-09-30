<?php
namespace ephp\data;

class EntityDuration extends Entity {

function is_active($today = null) {
  $today = $today ?? date('Y-m-d');
  if ( $this->is_expired($today) ) return false;
  if ( $this->is_about_to_start($today) ) return false;
  return true;
}

function fix_date($data, $default) {
  return preg_match('/^\d\d\d\d-\d\d-\d\d$/', $data) ? $data : $default;
}

function start_date($default = '0000-00-00') {
  $data = $this->data['start_date'] ?? $default ?? '';
  return $this->fix_date($data, $default);
}

function end_date($default = '9999-99-99') {
  $data = $this->data['end_date'] ?? $default ?? '';
  return $this->fix_date($data, $default);
}

function is_expired($today = null) {
  $today = $today ?? date('Y-m-d');
  return $this->start_date('0000-00-00') < $today && $this->end_date('9999-99-99') < $today;
}

function is_about_to_start($today = null) {
  $today = $today ?? date('Y-m-d');
  return $this->start_date('0000-00-00') > $today && $this->end_date('9999-99-99') > $today;
}

public static function last($list, callable $filter) {
  $last = null;
  $last_duration = null;
  foreach ( $list ?? [] as $e ) {
    $duration = $filter($e);
    if ( is_null($duration) ) continue;
    if ( !$duration->is_expired() ) continue;
    if ( empty($duration['end_date']) ) continue;
    if ( is_null($last) || $last_duration['end_date'] < $duration['end_date'] ) {
      $last = $e;
      $last_duration = $duration;
    }
  }
  if ( is_null($last) ) throw new \Exception('Not last');
  return $last;
}

public static function ongoing($list, callable $filter) {
  foreach ( $list ?? [] as $e ) {
    $duration = $filter($e);
    if ( is_null($duration) ) continue;
    if ( $duration->is_active() ) return $e;
  }
  throw new \Exception('Not ongoing');

}

}

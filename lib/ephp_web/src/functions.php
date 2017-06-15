<?php

function container__(...$args) {
  t__(...$args);
  return function (...$args2) {
    t__(['layout_container_inside'],...$args2);
  };
}

function __container() { __t(); __t(); }

function t__(...$args) { tag(...$args)->open(); }

function __t() { end(ephp\web\Tag::$stack)->close(); }

function tag(...$args) : ephp\web\Tag { return new ephp\web\Tag(...$args); }

function style(...$args) : ephp\web\Style { return new ephp\web\Style(...$args); }

function style_def(...$args) : ephp\web\Style {
  return \ephp\web\Styles::define( function(...$a) { return style('.', ...$a); }, ...$args);
}


function t_spacer() { \ephp\web\Tag::spacer(); }

function tr($data) { return \ephp\web\Format::tr($data); }

function url(string $url) : string { return \ephp\web\Builder::url($url); }

function current_url() : string { return \ephp\web\Builder::current_url(); }

function dg($guard = null) : bool { return \ephp\web\DefineGuard::guard($guard); }

function t_br() { \ephp\web\Tag::br(); }


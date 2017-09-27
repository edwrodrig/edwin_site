<?php

function t__(...$args) { return (new ephp\web\Tag(...$args))->open(); }

function __t() { end(\ephp\web\BuilderState::get()->tag_stack)->close(); }

function tag(...$args) : ephp\web\Tag { return new ephp\web\Tag(...$args); }

function style(...$args) : ephp\web\Style { return (new ephp\web\Style(...$args))->print(); }

function js($elem) { return new \ephp\web\Js($elem); }

function url(string $url) : string { return \ephp\web\Context::url($url); }

function current_url() : string { return \ephp\web\Context::current_url(); }

function dg($guard = null) : bool { return \ephp\web\DefineGuard::guard($guard); }


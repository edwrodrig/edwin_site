#!/usr/bin/php
<?php

$date = (new DateTime)->format('Y-m-d');

echo 'Title:';
$title = trim(fgets(STDIN));


$data = [
 'title' => ['en' => $title ],
 'description' => ['en' => $title],
 'date' => $date,
 'tags' => []
];


$str = json_encode($data, JSON_PRETTY_PRINT);
$str .= "\n---\n";

file_put_contents(__DIR__ . sprintf('/files/posts/%s-%s.md', $date, str_replace(' ', '-', strtolower($title))), $str); 

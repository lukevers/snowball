<?php

// This route is going to be different unless you're running this
// from two directories down--but you should already know that if
// you're looking here.
require __DIR__ . '/../../vendor/autoload.php';

// Create our bot with default parameters except for channels.
$bot = new Snowball\Bot(['channels' => ['#snowball']]);

// Now connect!
$bot->connect();

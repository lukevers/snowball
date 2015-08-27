<?php

// This route is going to be different unless you're running this
// from two directories down--but you should already know that if
// you're looking here.
require __DIR__ . '/../../vendor/autoload.php';

// Create our bot with default parameters except for channels.
$bot = new Snowball\Bot(['channels' => ['#snowball']]);

// Add a listener that echos everything back.
$bot->addListener('PRIVMSG', function($message) use ($bot) {
    $msg = implode($message->params, ' ');
    $bot->say($message->channel, $msg);
});

// Now connect!
$bot->connect();


<?php

// This route is going to be different unless you're running this
// from two directories down--but you should already know that if
// you're looking here.
require __DIR__ . '/../../vendor/autoload.php';

// Create our bot with default parameters except for channels.
$bot = new Snowball\Bot(['channels' => ['#snowball']]);

// Add a listener that prints out "HAYYYYYYYYY" on receiving the
// welcome message.
$bot->addListener('001', function($message) {
    echo "HAYYYYYYYYY" . PHP_EOL;
});

// Add a listener that parts the channel #snowball if the user
// types `snowcone` in the channel `#snowball`. Notice the use
// of the closure so we can use our bot object. (Yes, the bot
// named snowball is getting offended that you would even try
// to bring up the word `snowcone` in that channel!)
$bot->addListener('PRIVMSG', function($message) use ($bot) {
    if ($message->channel === '#snowball') {
        $msg = implode($message->params, ' ');
        if (strpos($msg, 'snowcone') > 0) {
            $bot->part('#snowball', 'HOW DARE YOU SPEAK SUCH WORDS. I AM LEAVING!');
        }
    }
});

// Now connect!
$bot->connect();

<?php

namespace Snowball\Irc;

class Message {

    /**
     * Contains the raw string.
     *
     * @var string $raw
     */
    public $raw;

    /**
     * Contains the prefix of the message.
     *
     * @var string $prefix
     */
    public $prefix;

    /**
     * Contains the command of the message.
     *
     * @var string $command
     */
    public $command;

    /**
     * Contains the channel of the message.
     *
     * @var string $channel
     */
    public $channel;

    /**
     * Contains the parameters of the message.
     *
     * @var [] $params
     */
    public $params;

    /**
     * Constructs a new Message
     *
     * @param string $raw
     */
    public function __construct($raw) {
        $this->raw = $raw;
        return $this->parse();
    }

    /**
     * Parse an Irc message.
     */
    private function parse() {
        if (strpos($this->raw, ':') !== 0) {
            // This is not the kind of message we want to parse here.
            return $this;
        }

        // Split the message up by spaces
        $args = explode(' ', $this->raw);

        // The first argument is the prefix, which starts with a colon.
        // Since the prefix doesn't actually start with a colon, we
        // want to remove it.
        $this->prefix = substr($args[0], 1);
        unset($args[0]);

        // The second argument is the command.
        $this->command = $args[1];
        unset($args[1]);

        // The third argument is the channel.
        $this->channel = $args[2];
        unset($args[2]);

        // We want to remove the colon from our first parameter if it
        // is in a commonly used message format like PRIVMSG.
        switch($this->command) {
            case '001':
            case '002':
            case '003':
            case 'PRIVMSG':
                $args[3] = substr($args[3], 1);
                break;
        }

        // Everything left over are parameters;
        $this->params = array_values($args);

        // Now let's return our Message!
        return $this;
    }

}

<?php

namespace Snowball;

use Snowball\Irc\Irc;
use Snowball\Irc\User;

class Bot extends User {

    /**
     * Contains the Irc connection.
     *
     * @var Snowball\Irc $conn
     */
    private $conn;

    /**
     * Constructs a new bot.
     *
     * @param [] $options
     */
    public function __construct($options = []) {
        $default = [
            'nickname' => 'snowball',
            'realname' => 'snowball',
            'host'     => 'localhost',
            'port'     => 6667,
            'ssl'      => false,
            'password' => '',
            'channels' => [],
        ];

        $options = array_merge($default, $options);

        $this->nickname = $options['nickname'];
        $this->realname = $options['realname'];
        $this->host     = $options['host'];
        $this->port     = $options['port'];
        $this->ssl      = $options['ssl'];
        $this->password = $options['password'];
        $this->channels = $options['channels'];

        // Create new Irc instance
        $this->conn = new Irc($this);
    }

    /**
     * Connect to the irc server.
     */
    public function connect() {
        $this->conn->connect();
    }

    /**
     * Part a channel
     *
     * @param string $channel
     */
    public function part($channel, $message = 'Bye') {
        $this->conn->write("PART $channel :$message");
    }

    /**
     * Join a channel
     *
     * @param string $channel
     */
    public function join($channel) {
        $this->conn->write("JOIN $channel");
    }

    /**
     * Say something in a channel
     *
     * @param string $channel
     * @param string $message
     */
    public function say($channel, $message) {
        $this->conn->write("PRIVMSG $channel $message");
    }

    /**
     * Add Listener
     *
     * @param string   $command
     * @param function $callback
     */
    public function addListener($command, $callback) {
        $this->conn->addListener($command, $callback);
    }

}

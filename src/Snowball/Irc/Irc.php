<?php

namespace Snowball\Irc;

use Snowball\Irc\Message;
use Snowball\Irc\User;

class Irc {

    /**
     * Contains the connection to the Irc server.
     *
     * @var $conn
     */
    private $conn;

    /**
     * Contains the user.
     *
     * @var Snowball\User $user
     */
    private $user;

    /**
     * Contains an array of listeners.
     *
     * @var [] $listeners
     */
    private $listeners = [];

    /**
     * Constructs a new Irc object.
     *
     * @param Sowball\User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Connect to an Irc server.
     */
    public function connect() {
        $this->conn = fsockopen($this->user->host, $this->user->port);
        if ($this->conn) {
            $this->write("NICK " . $this->user->nickname);
            $this->write("USER " . $this->user->nickname ." 0 * :" . $this->user->realname);
            while (!feof($this->conn)) {
                $raw = fgets($this->conn, 1024); 
                if (strpos($raw, 'PING') === 0) {
                    $this->pong($raw);
                } else if (strpos($raw, 'ERROR') === 0) {
                    $this->error($raw);
                } else {
                    $this->handle(new Message($raw));
                }
            }
            fclose($this->conn);
        } else {
            // Throw can't connect
        }
    }

    /**
     * Send command to the Irc server.
     *
     * @param string $command
     * @param bool   $newline
     */
    public function write($command, $newline = true) {
        fputs($this->conn, $command . ($newline ? " \r\n" : ""));
    }

    /**
     * Handle Errors
     *
     * @param string $raw
     */
    private function error($raw) {
        echo $raw;
    }

    /**
     * Pong
     *
     * @param string $raw
     */
    private function pong($raw) {
        $pong = explode(':', $raw)[1];
        $this->write("PONG :$pong", false);
    }

    /**
     * Handle Irc Messages
     *
     * @param Snowball\Irc\Message $message
     */
    private function handle(Message $message) {
        echo $message->raw;

        // Internal handling
        switch($message->command) {
            case '001':
                // On welcome we want to join all the channels.
                foreach($this->user->channels as $channel) {
                    $this->write("JOIN $channel");
                }
                break;
        }

        // External handling
        foreach($this->listeners as $command => $callbacks) {
            if ($message->command === $command) {
                foreach($callbacks as $cb) {
                    $cb($message);
                }
            }
        }
    }

    /**
     * Add Listeners
     *
     * @param string   $command
     * @param function $callback
     */
    public function addListener($command, $callback) {
        if (array_key_exists($command, $this->listeners)) {
            array_push($this->listeners[$command], $callback);
        } else {
            $this->listeners[$command] = [$callback];
        }
    }
}

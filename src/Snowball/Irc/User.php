<?php

namespace Snowball\Irc;

class User {

    /**
     * Contains the nickname of the bot.
     *
     * @var string
     */
    public $nickname;

    /**
     * Contains the real name of the bot.
     *
     * @var string
     */
    public $realname;

    /**
     * Contains the server address of the bot.
     *
     * @var string
     */
    public $host;

    /**
     * Contains the server port of the bot.
     *
     * @var int
     */
    public $port;

    /**
     * Contains a bool for ssl connection or not.
     *
     * @var bool
     */
    public $ssl;

    /**
     * Contains the password needed to connect.
     *
     * @var string
     */
    public $password;

    /**
     * Contains an array of channels to connect to.
     *
     * @var []
     */
    public $channels;

}

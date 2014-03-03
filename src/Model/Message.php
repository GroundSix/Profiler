<?php

namespace GroundSix\Component\Model;

class Message
{
    public
        $_time,
        $_message;

    public function __construct($message)
    {
        $this->_time = microtime();
        $this->_message = $message;
    }

    public function __get($key)
    {
        $key = '_' . $key;
        if (isset($this->$key)) {
            return $this->key;
        }

        return null;
    }
}

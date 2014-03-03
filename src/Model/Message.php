<?php

namespace GroundSix\Component\Model;

class Message
{
    protected
        $time,
        $message;

    public function __construct($message)
    {
        $this->time = microtime();
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }
}

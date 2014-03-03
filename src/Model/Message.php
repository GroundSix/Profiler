<?php

namespace GroundSix\Component\Model;

class Message
{
    protected
        $time,
        $message;

    /**
     * Passes the message through and sets the
     * initial time
     *
     * @param String new message
     */
    public function __construct($message)
    {
        $this->time = microtime(true);
        $this->message = $message;
    }

    /**
     * Gets the message for a given
     * push
     * 
     * @return String
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Gets the time for a given
     * push
     * 
     * @return Int
     */
    public function getTime()
    {
        return $this->time;
    }
}

<?php

/**
 * Ground Six Profiler
 *
 * @author Andrew Willis  twitter.com/ilovefluffy
 * @author Harry Lawrence twitter.com/harry4_
 *
 * (c) Ground Six 2014
 *
 * License: MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GroundSix\Component\Model;

/**
 * Class Message
 *
 * @package GroundSix\Component\Model
 */
class Message extends BaseModel
{
    protected
        $time,
        $message;

    /**
     * Passes the message through and sets the
     * initial time
     *
     * @param String $message new message
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->time = microtime(true);
        $this->message = $message;
    }

    /**
     * Gets the message for a given push
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
     * @return Float
     */
    public function getTime($format = false)
    {
        if ($format) {
            return $this->microtimeToDateFormat($this->time);
        }
        return $this->time;
    }

    /**
     * Returns the message and the time
     *
     * @return Object message and time
     */
    public function getData()
    {
        $message = $this->message;
        $time    = $this->microtimeToDateFormat($this->time);

        // Consistency, return an object
        return (object) compact('message', 'time');
    }
}

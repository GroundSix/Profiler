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
class Message implements \JsonSerializable
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
     * @return Float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        $message = $this->message;
        $time = $this->time;
        return compact('message', 'time');
    }


}

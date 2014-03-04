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
 * Class Profile
 * 
 * @package GroundSix\Component\Model
 */
class Profile implements \JsonSerializable
{
    protected
        $startTime,
        $endTime,
        $messages = array(),
        /**
         * @var Profile[]
         */
    $profiles = array(),
        $open = true;

    public function __construct()
    {
        $this->startTime = microtime(true);
    }

    /**
     * @param Profile $profile
     * 
     * @throws \Exception
     * @return Null
     */
    public function addProfile(Profile &$profile)
    {
        if ($this->open) {
            if (is_a($profile, '\GroundSix\Component\Model\Profile')) {
                $this->profiles[] = $profile;
            } else {
                throw new \Exception("Provided object is not a Profile");
            }
        } else {
            throw new \Exception("Trying to add profile after closing the profile");
        }
    }

    /**
     * @param String $message
     * 
     * @throws \Exception
     * @return Null
     */
    public function addMessage($message)
    {
        if ($this->open) {
            if (is_string($message)) {
                $this->messages[] = new Message($message);
            } else {
                throw new \Exception("Message provided is not a string");
            }
        } else {
            throw new \Exception("Trying to add message after closing the profile");
        }
    }

    /**
     * Gets all of the messages
     * 
     * @return \GroundSix\Component\Model\Message[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Gets all of the profiles
     * 
     * @return \GroundSix\Component\Model\Profile[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return Float
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return Float
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return Null
     */
    public function close()
    {
        $this->open = false;
        $this->endTime = microtime(true);

        foreach ($this->profiles as $profile) {
            $profile->close();
        }
    }

    /**
     * (PHP 5 >= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        $object = new \stdClass;
        $object->startTime = $this->startTime;
        $object->endTime = $this->endTime;
        $object->messages = $this->messages;
        $object->profiles = $this->profiles;

        return $object;

    }

}

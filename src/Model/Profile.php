<?php

namespace GroundSix\Component\Model;

/**
 * Class Profile
 * @package GroundSix\Component\Model
 */
class Profile
{
    protected
        $startTime,
        $endTime,
        $messages = array(),
        $profiles = array(),
        $open = true;

    public function __construct($message)
    {
        $this->addMessage($message);
        $this->startTime = microtime(true);
    }

    /**
     * @param Profile $profile
     * @throws \Exception
     */
    public function addProfile(Profile $profile)
    {
        if ($this->open) {
            $this->profiles[] = $profile;
        } else {
            throw new \Exception("Trying to add profile after closing the profile");
        }

    }

    /**
     * @param String $message
     * @throws \Exception
     */
    public function addMessage($message)
    {
        if ($this->open) {
            $this->messages[] = new Message($message);
        } else {
            throw new \Exception("Trying to add message after closing the profile");
        }
    }

    /**
     * @return \GroundSix\Component\Model\Message[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return \GroundSix\Component\Model\Profile[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return Int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return Int
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
    }
}

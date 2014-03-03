<?php

namespace GroundSix\Component\Model;

/**
 * Class Profile
 * @package GroundSix\Component\Model
 */
class Profile
{
    protected $startTime;
    protected $endTime;
    protected $messages = array();
    protected $profiles = array();

    public function __construct($message)
    {
        $this->addMessage($message);
        $this->startTime = microtime();
    }

    /**
     * @param Profile $profile
     */
    public function addProfile(Profile $profile)
    {
        $this->profiles[] = $profile;
    }

    /**
     * @param string $message
     */
    public function addMessage($message)
    {
        $this->messages[] = new Message($message);
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
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     *
     */
    public function close()
    {
        $this->endTime = microtime();
    }
}

<?php

namespace GroundSix\Component\Model;


class Profile
{
    public $startTime;
    public $endTime;
    public $messages;
    public $profiles = array();

    public function __construct($message)
    {
        $this->addMessage($message);
        $this->startTime = microtime();
    }

    public function addProfile(Profile $profile)
    {
        $this->profiles[] = $profile;
    }

    public function addMessage($message)
    {
        $this->messages[microtime()] = $message;
    }
}
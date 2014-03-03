<?php

namespace GroundSix\Component\Model;


class Profile
{
    protected $_startTime;
    protected $_endTime;
    protected $_messages;
    protected $_profiles = array();

    public function __construct($message)
    {
        $this->addMessage($message);
        $this->_startTime = microtime();
    }

    public function addProfile(Profile $profile)
    {
        $this->_profiles[] = $profile;
    }

    public function addMessage($message)
    {
        $this->_messages[] = new Message($message);
    }

    public function __get($key)
    {
        $key = '_' . $key;
        if (isset($this->$key))
        {
            return $this->$key;
        }
        return null;
    }

    public function close()
    {
        $this->_endTime = microtime();
    }
}
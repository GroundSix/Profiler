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
class Profile extends BaseModel
{
    /**
     * @var Float $startTime
     * @var Float $endTime
     * @var \GroundSix\Component\Collection\Message
     * @var \GroundSix\Component\Collection\Profile
     * @var String
     */
    protected
        $startTime,
        $endTime,
        $messages,
        $profiles,
        $id,
        $name;

    /**
     * Sets a new start time and creates an instance
     * of both the Profile and Message collection
     *
     * @return Null
     */
    public function __construct()
    {
        parent::__construct();
        $this->startTime = microtime(true);
        $this->profiles  = new Collection('GroundSix\Component\Model\Profile');
        $this->messages  = new Collection('GroundSix\Component\Model\Message');
    }

    /**
     * @param Profile $profile
     *
     * @throws \Exception
     *
     * @return Null
     */
    public function addProfile(Profile &$profile)
    {
        if (is_null($this->endTime)) {
            if (! in_array($profile, (array) $this->profiles)) {
                $this->profiles->add($profile);
            }
        } else {
            throw new \Exception("Trying to add profile after closing the profile");
        }
    }

    /**
     * @param String $message
     *
     * @throws \Exception
     *
     * @return Null
     */
    public function addMessage($message)
    {
        if (is_null($this->endTime)) {
            if (is_string($message)) {
                $this->messages->add(new Message($message));
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
     * @return \GroundSix\Component\Collection\Message
     *
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Gets all of the profiles
     *
     * @return \GroundSix\Component\Collection\Profile
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * Gets the start time
     *
     * @return string|Float
     */
    public function getStartTime($format = false)
    {
        if ($format && !is_null($this->startTime)) {
            return $this->microtimeToDateFormat($this->startTime);
        }
        return $this->startTime;
    }

    /**
     * Gets the end time
     *
     * @return Float
     */
    public function getEndTime($format = false)
    {
        if ($format && !is_null($this->endTime)) {
            return $this->microtimeToDateFormat($this->endTime);
        }
        return $this->endTime;
    }

    /**
     * Recursively closes each profile
     *
     * @return Null
     */
    public function close()
    {
        if (is_null($this->endTime)) {
            $this->endTime = microtime(true);

            foreach ($this->profiles->get() as $profile) {
                $profile->close();
            }
        }
    }

    /**
     * Returns time and message data in the
     * form of a stdClass
     *
     * @return object|\stdClass
     */
    public function getData()
    {
        return (object) array(
            'name' => $this->getName(),
            'startTime' => $this->microtimeToDateFormat($this->startTime, 'H:i:s'),
            'endTime'  => $this->microtimeToDateFormat($this->endTime, 'H:i:s'),
            'rawStartTime' => number_format($this->startTime, 3, '.', ''),
            'rawEndTime' => number_format($this->endTime, 3, '.', ''),
            'duration' => $this->getDuration(),
            'messages' => $this->messages->getData(),
            'profiles' => $this->profiles->getData()
        );
    }

    /**
     * Get the duration of the profiled excecution
     *
     * @return string
     */
    public function getDuration()
    {
        if (is_null($this->endTime)) {
            return number_format(round(($this->endTime - microtime(true)), 3), 3, '.', '');
        }
        return number_format(round(($this->endTime - $this->startTime), 3), 3, '.', '');
    }

    /**
     * Set the profiles name
     *
     * @param String $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get the profiles name, or its ID if the name is null
     *
     * @return String
     */
    public function getName()
    {
        return !is_null($this->name) ? $this->name : $this->id;
    }
}

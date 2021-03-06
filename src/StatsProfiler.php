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

namespace GroundSix\Component;

/**
 * Class StatsProfiler
 * @package GroundSix\Component
 */
class StatsProfiler implements Profiler
{
    /** 
     * @var Model\Profile $profile
     * @var Profiler[] $profilers
     * @var \Psr\Log\AbstractLogger $logger
     * @var Profiler $parent
     * @var bool 
     */
    protected
        $profile,
        $profilers = array(),
        $logger,
        $parent,
        $logActive = false;

    /**
     * Creates a new profile, assign the parent
     * and creates an instance of the null logger
     *
     * @param \GroundSix\Component\Profiler profiler instance
     *
     * @return Null
     */
    public function __construct(Profiler &$profiler = null)
    {
        $this->profile = new Model\Profile;
        $this->parent  = &$profiler;
        $this->logger  = new \Psr\Log\NullLogger();
    }

    /**
     * Name the current profile
     *
     * @param String $name The name to be assigned to the profile
     */
    public function setName($name)
    {
        $this->profile->setName($name);
    }

    /**
     * Starts the profiling process
     *
     * @param  String $name The optional name of the profile
     *
     * @return Object|\GroundSix\Component\StatsProfiler
     */
    public function start($name = '')
    {
        $profiler = new StatsProfiler($this);
        if ($name !== '') {
            $profiler->setName($name);
        }

        $this->profilers[] = &$profiler;
        return $profiler;
    }

    /**
     * Stops the last profiling process
     *
     * @return Null
     */
    public function stop()
    {
        foreach ($this->profilers as $profiler) {
            if (is_null($this->profile->getEndTime())) {
                $child_profile = $profiler->fetch();
                $this->profile->addProfile($child_profile);
                $profiler->stop();
            }
        }
        $this->profile->close();
    }

    /**
     * Appends a message to the profile at the current time
     *
     * @param  String $message Optional message to be logged on push
     *
     * @return Null
     */
    public function push($message = '')
    {
        $this->profile->addMessage($message);
    }

    /**
     * Get the profile
     *
     * @return Model\Profile
     */
    public function fetch()
    {
        if (!is_null($this->profile->getEndTime())) {
            $this->makeLog();
            return $this->profile;
        }
        $profile = clone $this->profile;
        foreach ($this->profilers as $profiler) {
            $child_profile = $profiler->fetch();
            $profile->addProfile($child_profile);
        }
        return $profile;
    }

    /**
     * Kill all parent and child profiles
     *
     * @return Null
     */
    public function kill()
    {
        $this->stop();
        if (! is_null($this->parent)) {
            return $this->parent->kill();
        }
        return $this->fetch();
    }

    /**
     * Set the logger to override null logger
     *
     * @param Object|\Psr\Log\LoggerInterface
     *
     * @return Null
     */
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Push JSON to logger
     *
     * @return Null
     */
    protected function makeLog()
    {
        $this->logger->debug(date('Y-m-d H:i:s') . '-' . $this->profile->toJson());
    }

    /**
     * Stop logging and fetch all logged
     * data
     *
     * @return Null
     */
    public function __destruct()
    {
        $this->stop();
        if (is_null($this->parent)) {
            $this->fetch();
        }
    }
}

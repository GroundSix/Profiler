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

    public function __construct(Profiler &$profiler = null)
    {
        $this->profile = new Model\Profile;
        $this->parent  = &$profiler;
        $this->logger  = new \Psr\Log\NullLogger();
    }

    /**
     * Starts the profiling process
     *
     * @param  String $message Optional message to be logged on start
     *
     * @return Object|\GroundSix\Component\StatsProfiler
     */
    public function start($message = '')
    {
        $profiler = new StatsProfiler($this);
        if ($message !== '') {
            $profiler->push($message);
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
        if (!is_null($this->profile->getEndTime()))
        {
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
            $this->parent->kill();
        }
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
        $this->logger->debug($this->profile->toJson());
    }

    public function __destruct()
    {
        $this->stop();
        if (is_null($this->parent)) {
            $this->fetch();
        }
    }
}

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

class StatsProfiler implements Profiler
{

    /**
     * @var Model\Profile $profile
     */
    protected $profile,
        $logger,
        $parent;

    public function __construct(Profiler $profiler = null)
    {
        $this->parent = $profiler;
        $this->logger = new \Psr\Log\NullLogger();
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
        $this->profile = new Model\Profile($message);
        return new StatsProfiler($this);
    }

    /**
     * Stops the last profiling process
     *
     * @return Null
     */
    public function stop()
    {
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

    }

    public function fetch()
    {

    }

    public function kill()
    {

    }

    public function setLogger(Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}

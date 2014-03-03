<?php

namespace GroundSix\Component;

class StatsProfiler implements Profiler
{

    /**
     * @var Array $profiles;
     */
    protected $profiles;

	/**
	 * Starts the profiling process
	 * 
	 * @param  String $message Optional message to be logged on start
	 * 
	 * @return Object|\GroundSix\Component\StatsProfiler
	 */
    public function start($message = '')
    {
    }

	/**
	 * Stops the last profiling process
	 * 
	 * @return Null
	 */
    public function stop()
    {

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
}
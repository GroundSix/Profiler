<?php

namespace GroundSix\Component;

class ProfileTest extends \PHPUnit_Framework_TestCase
{

    protected $profiler;

    public function __construct()
    {
        $this->profiler = new StatsProfiler;
    }

    public function testCreateProfile()
    {

    }
} 
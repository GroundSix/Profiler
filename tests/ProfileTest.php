<?php

namespace GroundSix\Component;

class ProfileTest extends \PHPUnit_Framework_TestCase
{

    protected $profiler;

    public function testCreateProfile()
    {
        $this->profiler = new StatsProfiler;
        $this->profiler->start("Begin Profiling");
    }

    public function testExtraProfile()
    {

    }
} 
<?php

namespace GroundSix\Component;

use Mockery as M;

class ProfileTest extends \PHPUnit_Framework_TestCase
{

    protected $profiler;

    public function __construct()
    {
        $this->profiler = M::mock('Profiler');
    }

    public function testCreateProfile()
    {
    }
} 
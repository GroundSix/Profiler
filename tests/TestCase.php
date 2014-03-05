<?php

namespace GroundSix\Component;

use Monolog\Handler\TestHandler;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    /** @var \Monolog\Logger */
    public $logger = null;
    public function setUp()
    {
        $timezone = ini_get('date.timezone');
        if (is_null($timezone) || !$timezone) {
            date_default_timezone_set('UTC');
        }
        $this->logger = new Logger\TestLogger();

    }

    public function tearDown()
    {
    }
} 
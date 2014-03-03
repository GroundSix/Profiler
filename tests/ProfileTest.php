<?php

namespace GroundSix\Component;

class ProfileTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateProfiler()
    {
        $profiler = new StatsProfiler();
        $this->assertInstanceOf('\GroundSix\Component\Profiler', $profiler);
    }

    public function testTieredProfiles()
    {
        $profiler = new StatsProfiler();
        $tier_1 = $profiler->start("Tier 1");
        $this->assertInstanceOf('\GroundSix\Component\Profiler', $tier_1);
        $tier_2 = $tier_1->start("Tier 2");
        $this->assertInstanceOf('\GroundSix\Component\Profiler', $tier_2);
    }

    public function testPushMessage()
    {
        $profiler = new StatsProfiler();
        $msg_1 = "Message 1";
        $profiler->push($msg_1);
        $profile_1 = $profiler->fetch();
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $profile_1);
        $messages = $profile_1->getMessages();
        $this->assertEquals(1, count($messages));
        $this->assertEquals($msg_1, $messages[0]->getMessage());
        $this->assertGreaterThanOrEqual($profile_1->getStartTime(), $messages[0]->getTime());
        $msg_2 = "Message 2";
        $profiler->push($msg_2);
        $profile_2 = $profiler->fetch();
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $profile_2);
        $messages = $profile_2->getMessages();
        $this->assertEquals(2, count($messages));
        $this->assertEquals($msg_1, $messages[0]->getMessage());
        $this->assertEquals($msg_2, $messages[1]->getMessage());
        $this->assertGreaterThanOrEqual($profile_2->getStartTime(), $messages[0]->getTime());
        $this->assertGreaterThanOrEqual($messages[0]->getTime(), $messages[1]->getTime());
    }

    public function testStopProfiler()
    {
        $profiler_1 = new StatsProfiler();
        $profiler_2 = $profiler_1->start();
        $profiler_3 = $profiler_2->start();
        $profiler_4 = $profiler_3->start();
        $profiler_5 = $profiler_4->start();
    }

    public function testKillProfiler()
    {
        $profiler_1 = new StatsProfiler();
        $profiler_2 = $profiler_1->start();
        $profiler_3 = $profiler_2->start();
        $profiler_4 = $profiler_3->start();
        $profiler_5 = $profiler_4->start();
    }
} 
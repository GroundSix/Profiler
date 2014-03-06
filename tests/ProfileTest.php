<?php

namespace GroundSix\Component;

class ProfileTest extends TestCase
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
        $this->assertEquals(2, $messages->count());
        $this->assertEquals($msg_1, $messages[0]->getMessage());
        $this->assertEquals($msg_2, $messages[1]->getMessage());
        $this->assertGreaterThanOrEqual($profile_2->getStartTime(), $messages[0]->getTime());
        $this->assertGreaterThanOrEqual($messages[0]->getTime(), $messages[1]->getTime());
    }

    public function testStopProfiler()
    {
        $profiler_1 = new StatsProfiler();
        $profiler_1->setLogger($this->logger);
        $profiler_2 = $profiler_1->start('1');
        $profiler_3 = $profiler_2->start('2');
        $profiler_4 = $profiler_3->start('3');
        $profiler_5 = $profiler_4->start('4');

        $profiler_4->stop();
        $this->assertNotNull($profiler_4->fetch()->getEndTime());
        $this->assertNotNull($profiler_5->fetch()->getEndTime());
        $this->assertNull($profiler_1->fetch()->getEndTime());
        $this->assertNull($profiler_2->fetch()->getEndTime());
        $this->assertNull($profiler_3->fetch()->getEndTime());
        $profiler_3->stop();
        $this->assertNotNull($profiler_4->fetch()->getEndTime());
        $this->assertNotNull($profiler_5->fetch()->getEndTime());
        $this->assertNull($profiler_1->fetch()->getEndTime());
        $this->assertNull($profiler_2->fetch()->getEndTime());
        $this->assertNotNull($profiler_3->fetch()->getEndTime());
        $profiler_1->stop();
        $this->assertNotNull($profiler_1->fetch()->getEndTime());
        $this->assertNotNull($profiler_2->fetch()->getEndTime());
        $this->assertNotNull($profiler_3->fetch()->getEndTime());
        $this->assertNotNull($profiler_4->fetch()->getEndTime());
        $this->assertNotNull($profiler_5->fetch()->getEndTime());

        $this->assertEquals($this->logger->debugData, $profiler_1->fetch()->toJson());
        $this->assertNotEquals($this->logger->debugData, $profiler_5->fetch()->toJson());
    }

    public function testKillProfiler()
    {
        $profiler_1 = new StatsProfiler();
        $profiler_2 = $profiler_1->start();
        $profiler_3 = $profiler_2->start();
        $profiler_4 = $profiler_3->start();
        $profiler_5 = $profiler_4->start();
        $profiler_3->kill();
        $this->assertNotNull($profiler_1->fetch()->getEndTime());
        $this->assertNotNull($profiler_2->fetch()->getEndTime());
        $this->assertNotNull($profiler_3->fetch()->getEndTime());
        $this->assertNotNull($profiler_4->fetch()->getEndTime());
        $this->assertNotNull($profiler_5->fetch()->getEndTime());
    }

    public function testDestructor()
    {
        $profiler_1 = new StatsProfiler();
        $profiler_1->setLogger($this->logger);
        $profiler_2 = $profiler_1->start();
        $profiler_1->__destruct();
        $this->assertNotNull($profiler_2->fetch()->getEndTime());

        $this->assertContains($profiler_2->fetch()->toJson(), $this->logger->debugData);
    }
} 
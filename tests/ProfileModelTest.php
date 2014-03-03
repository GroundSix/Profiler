<?php

namespace GroundSix\Component;


use GroundSix\Component\Model\Profile;

class ProfileModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $profile Model\Profile
     */
    public $profile;

    public function testModelInstantiation()
    {
        $profile = new Profile("Model Test 1");
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $profile);
        $messages = $profile->getMessages();
        $this->assertEquals(1, count($messages));
        $this->assertEquals("Model Test 1", $messages[0]->getMessage());
        $this->assertLessThanOrEqual(microtime(true), $messages[0]->getTime());
    }

    public function testAddMessage()
    {
        $profile = new Profile("Model Test 1");
        $profile->addMessage("Model Test 2");
        $messages = $profile->getMessages();
        $this->assertEquals(2, count($messages));
        $this->assertEquals("Model Test 2", $messages[1]->getMessage());
        $this->assertLessThanOrEqual(microtime(true), $messages[1]->getTime());
        $this->assertGreaterThanOrEqual($messages[0]->getTime(), $messages[1]->getTime());
        $profile->close();
        $exception = false;
        try {
            $profile->addMessage("Fail Model Test");
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertTrue($exception);
    }

}

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
        $closed_messages = $profile->getMessages();
        $this->assertEquals(2, count($closed_messages));
    }

    public function testAddProfile()
    {
        $profile = new Profile("Test Message 1");
        $new_profile = new Profile("Test Message 2");
        $profile->addProfile($new_profile);
        $child_profiles = $profile->getProfiles();

        $this->assertEquals(1, count($child_profiles));
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $child_profiles[0]);
        $child_profile_0_messages = $child_profiles[0]->getMessages();
        $this->assertEquals($child_profile_0_messages[0]->getMessage(), "Test Message 2");

        $another_child_profile = new Profile("Test Message 3");

        $profile->addProfile($another_child_profile);

        $child_profiles = $profile->getProfiles();
        $this->assertEquals(2, count($child_profiles));
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $child_profiles[1]);
        $child_profile_1_messages = $child_profiles[1]->getMessages();
        $this->assertEquals($child_profile_1_messages[0]->getMessage(), "Test Message 3");
        $profile->close();
        $exception = false;
        try {
            $third_profile = new Profile("Test Message 4");
            $profile->addProfile($third_profile);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertTrue($exception);
        $closed_profiles = $profile->getProfiles();
        $this->assertEquals(2, count($closed_profiles));

    }
}

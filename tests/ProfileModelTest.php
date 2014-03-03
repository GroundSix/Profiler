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

use GroundSix\Component\Model\Profile;

class ProfileModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $profile Model\Profile
     */
    public $profile;

    public function testModelInstantiation()
    {
        $profile = new Profile();
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $profile);
        $messages = $profile->getMessages();
        $this->assertEquals(0, count($messages));
    }

    public function testAddMessage()
    {
        $profile = new Profile();
        $profile->addMessage("Model Test 1");
        $messages = $profile->getMessages();
        $this->assertEquals(1, count($messages));
        $this->assertEquals("Model Test 1", $messages[0]->getMessage());
        $this->assertLessThanOrEqual(microtime(true), $messages[0]->getTime());
        $profile->addMessage("Model Test 2");
        $messages = $profile->getMessages();
        $this->assertEquals(2, count($messages));
        $this->assertEquals("Model Test 2", $messages[1]->getMessage());
        $this->assertLessThanOrEqual(microtime(true), $messages[1]->getTime());
        $this->assertGreaterThanOrEqual($messages[0]->getTime(), $messages[1]->getTime());

        $exception = false;

        try {
            $profile->addMessage(array("Invalid message"));
        } catch (\Exception $e) {
            $exception = true;
        }

        $this->assertTrue($exception);
        $messages = $profile->getMessages();

        $this->assertEquals(2, count($messages));

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
        $profile = new Profile();
        $new_profile = new Profile();
        $profile->addProfile($new_profile);
        $child_profiles = $profile->getProfiles();

        $this->assertEquals(1, count($child_profiles));
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $child_profiles[0]);

        $another_child_profile = new Profile();

        $profile->addProfile($another_child_profile);

        $child_profiles = $profile->getProfiles();
        $this->assertEquals(2, count($child_profiles));
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $child_profiles[1]);
        $exception = false;

        try {
            $error_profile = "error";
            $profile->addProfile($error_profile);
        } catch (\Exception $e) {
            $exception = true;
        }

        $this->assertTrue($exception);

        $profile->close();
        $exception = false;
        try {
            $third_profile = new Profile();
            $profile->addProfile($third_profile);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertTrue($exception);
        $closed_profiles = $profile->getProfiles();
        $this->assertEquals(2, count($closed_profiles));
    }
}

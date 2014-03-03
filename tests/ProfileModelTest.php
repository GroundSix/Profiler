<?php

namespace GroundSix\Component;


use GroundSix\Component\Model\Profile;

class ProfileModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $profile Model\Profile
     */
    public $profile;

    public function __construct()
    {
        $this->profile = new Profile("Model Test 1");
    }
    public function testModelInstantiation()
    {
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $this->profile);
        $messages = $this->profile->getMessages();
        $this->assertEquals(1, count($messages));
        $this->assertEquals("Model Test 1", $messages[0]->getMessage());
        $this->assertLessThanOrEqual(microtime(), $messages[0]->getTime);
    }
<<<<<<< HEAD

    public function testAddMessage()
    {
        $this->profile->addMessage("Model Test 2");
        $messages = $this->profile->getMessages();
        $this->assertEquals(2, count($messages));
        $this->assertEquals("Model Test 2", $messages[1]->getMessage());
        $this->assertLessThanOrEqual(microtime(), $messages[1]->getTime());
        $this->assertGreaterThanOrEqual($messages[0]->getTime(), $messages[1]->getTime());
    }
}
=======
}
 
>>>>>>> d88f633c112662b000f96641b84b814933449785

<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03/03/2014
 * Time: 13:24
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
        $this->profile = new Profile("Model Test 1");
        $this->assertInstanceOf('\GroundSix\Component\Model\Profile', $this->profile);
        $this->assertEquals(1, count($this->profile->messages));
    }


} 
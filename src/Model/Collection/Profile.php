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

namespace GroundSix\Component\Model\Collection;

/**
 * Class Profile
 *
 * @package GroundSix\Component\Model\Collection
 */
class Profile implements \ArrayAccess, \Countable
{
    protected
        $profiles = array();

    public function count()
    {
        return count($this->profiles);
    }

    public function add(\GroundSix\Component\Model\Profile &$profile)
    {
        $this->profiles[] = $profile;
    }

    public function get()
    {
        return $this->profiles;
    }

    /**
     * (PHP 5 >= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->profiles[$offset]);

    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if (isset($this->profiles[$offset])) {
            return $this->profiles[$offset];
        }
        return null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (! is_a($value, '\GroundSix\Component\Model\Profile')) {
            throw new \Exception("Attempting to add an invalid item to the Profile collection");
        }
        if (is_null($offset)) {
            $this->profiles[] = $value;
            return;
        }
        if (isset($this->profiles[$offset])) {
            throw new \Exception("Can not modify profiles in a collection");
        }

        $this->profiles[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->profiles[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->profiles;
    }
}

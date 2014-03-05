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

namespace GroundSix\Component\Collection;

/**
 * Class Message
 *
 * @package GroundSix\Component\Model\Collection
 */
class BaseCollection implements \ArrayAccess, \Countable
{
    /**
     * @var \GroundSix\Component\Model\BaseModel[]
     */
    protected $elements = array();

    protected $elementType = null;

    public function count()
    {
        return count($this->elements);
    }

    /**
     * @param \GroundSix\Component\Model\BaseModel $element
     */
    public function add(\GroundSix\Component\Model\BaseModel $element)
    {
        $this->elements[] = $element;
    }

    /**
     * @return \GroundSix\Component\Model\BaseModel[]
     */
    public function get()
    {
        return $this->elements;
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
        return isset($this->elements[$offset]);

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
        if (isset($this->elements[$offset])) {
            return $this->elements[$offset];
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
    public function offsetSet($offset, $element)
    {

        if (! is_a($element, $this->elementType)) {
            throw new \Exception("Attempting to add an invalid item collection");
        }
        if (is_null($offset)) {
            $this->elements[] = $element;
            return;
        }
        if (isset($this->elements[$offset])) {
            throw new \Exception("Can not modify messages in a collection");
        }

        $this->elements[$offset] = $element;
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
        unset($this->elements[$offset]);
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
        return $this->elements;
    }
}
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

namespace GroundSix\Component\Model;

/**
 * Class BaseModel
 *
 * @package GroundSix\Component\Model
 */
abstract class BaseModel
{
    protected
        $id;

    /**
     * Get the relevant data from the object
     *
     * @return Object
     */
    abstract public function getData();

    public function __construct()
    {
        $this->generateId();
    }

    /**
     * generate the ID for the model
     *
     * @return String
     */
    public function generateId () {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this->id = '';
        for ($i = 0; $i < 16; $i++) {
            $this->id .= $characters[rand(0, strlen($characters) - 1)];
            if (($i) % 4 === 0 && ($i + 1) < 16) {
                $this->id .= '-';
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Convert microtime to a date format so it's not so
     * unpleasing on the eye
     *
     * @param Bool $microtime
     * @param String $format
     *
     * @return String
     */
    public function microtimeToDateFormat($microtime = false, $format = 'Y-m-d H:i:s')
    {
        if (! $microtime) {
            $microtime = microtime(true);
        }
        $seconds = floor($microtime);
        $microseconds = $microtime - $seconds;
        list($i, $microseconds) = explode('.', round($microseconds, 3));
        
        return date($format, $seconds) . '.' . $microseconds;
    }

    /**
     * Get the data as json
     *
     * @return string
     */
    final public function toJson()
    {
        return json_encode($this->getData());
    }

    /**
     * Allow to echo object as string
     * in the form of JSON
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson($this);
    }
}

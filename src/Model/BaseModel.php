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
    abstract public function jsonSerialize();

    /**
     * Convert microtime to a date format so it isn't so unpleasing on the eye
     *
     * @param float $microtime
     * @param string $format
     * @return string
     */
    public function microtimeToDateFormat($microtime = false, $format = 'Y-m-d H:i:s')
    {
        if (! $microtime) {
            $microtime = microtime(true);
        }
        $seconds = floor($microtime);
        $microseconds = $microtime - $seconds;
        list($i, $microseconds) = explode('.', round($microseconds, 6));
        return date($format, $seconds) . '.' . $microseconds;
    }
}

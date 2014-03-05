<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 05/03/2014
 * Time: 09:25
 */

namespace GroundSix\Component\Model;


abstract class BaseModel {
    abstract public function jsonSerialize();

    /**
     * Convert microtime to a date format so it isn't so unpleasing on the eye
     *
     * @param float $microtime
     * @param string $format
     * @return string
     */
    public function microtimeToDateFormat($microtime = false, $format = 'Y-m-d H:i:s') {
        if (! $microtime) {
            $microtime = microtime(true);
        }
        $seconds = floor($microtime);
        $microseconds = $microtime - $seconds;
        list($i, $microseconds) = explode('.', round($microseconds, 6));
        return date($format, $seconds) . '.' . $microseconds;
    }
} 
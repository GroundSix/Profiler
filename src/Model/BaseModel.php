<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 05/03/2014
 * Time: 09:25
 */

namespace GroundSix\Component\Model;


abstract class BaseModel {

    /**
     * Get the relevant data from the object
     *
     * @return object
     */
    abstract public function getData();

    /**
     * Convert microtime to a date format so it's not so unpleasing on the eye
     *
     * @param bool $microtime
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
     * @return string
     */
    public function __toString()
    {
        return $this->toJson($this);
    }
} 
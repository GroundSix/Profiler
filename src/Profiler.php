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

/**
 * Interface Profiler
 * 
 * @package GroundSix\Component
 */
interface Profiler
{
    public function start($message = '');
    public function stop();
    public function push($message = '');
    public function fetch();
    public function kill();
}

if (version_compare(PHP_VERSION, '5.4.0', 'lt')) {
    class_alias(
        'GroundSix\Component\Polyfill\JsonSerializable',
        'JsonSerializable'
    );
}

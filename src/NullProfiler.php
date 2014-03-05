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

class NullProfiler implements Profiler
{
    public function start($message = '') {}
    public function stop() {}
    public function push($message = '') {}
    public function fetch() {}
    public function kill() {}
    public function setLogger(\Psr\Log\LoggerInterface $logger) {}
}
